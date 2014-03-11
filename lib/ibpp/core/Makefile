# Filename   : Makefile
# Created By : Matt Hortman
# $Id: Makefile,v 1.19 2002/09/01 00:25:56 epocman Exp $
# Makefile for IBPP library

# *************************************************
# Source Files
# *************************************************

HDRS =ibpp.h
HDRS+=_internals.h
HDRS+=ibase.h
HDRS+=iberror.h

CORE_SRCS =_dpb.cpp
CORE_SRCS+=_ibs.cpp
CORE_SRCS+=_rb.cpp
CORE_SRCS+=_spb.cpp
CORE_SRCS+=_tpb.cpp
CORE_SRCS+=array.cpp
CORE_SRCS+=blob.cpp
CORE_SRCS+=database.cpp
CORE_SRCS+=dbkey.cpp
CORE_SRCS+=exception.cpp
CORE_SRCS+=service.cpp
CORE_SRCS+=statement.cpp
CORE_SRCS+=transaction.cpp
CORE_SRCS+=user.cpp

HELPER_SRCS+=date.cpp
HELPER_SRCS+=time.cpp

#
#	Set FBHEADERS to point to the include directory of your firebird distro
#

#FBHEADERS	=	c:/cygwin/home/olivier
#FBHEADERS	=	/usr/local/firebird/include
FBHEADERS	=	$(HOME)

# *************************************************
# Conditional Compile Options
# *************************************************

PLATFORM?=linux

# set target directories
ifeq ($(DEBUG),1)
	TARGETDIR=debug
else
	TARGETDIR=release
endif

# building on linux
	CXXFLAGS+=-DIBPP_LINUX
	CXXFLAGS+=-DIBPP_GCC
	LIBS+=-lfbclient -lcrypt -lm # dependancies for shared library
	CCOUTPUT=-o

	ifeq ($(TARGETDIR),release)
		CXXFLAGS+= -O2
	else
		CXXFLAGS+= -g -DDEBUG -Wall
	endif

# *************************************************
# Compile and Linker Options
# *************************************************

# To find the firebird includes
CXXFLAGS+=-I$(FBHEADERS)

# *************************************************
# Derived Definitions
# *************************************************

# make an object from each source file
CORE_OBJS:=$(addprefix $(TARGETDIR)/$(PLATFORM)/,$(addsuffix .o,$(basename $(CORE_SRCS))))
HELPER_OBJS:=$(addprefix $(TARGETDIR)/$(PLATFORM)/,$(addsuffix .o,$(basename $(HELPER_SRCS))))

# *************************************************
# Build Rules
# *************************************************

# don't check for existance of files named:
.PHONY: run edit ctags debug release targets

#don't delete when generated indirectly
.SECONDARY: $(HDRS) $(SRCS)

all: release debug

debug:
	$(MAKE) DEBUG=1 BUILDDEPENDANCIES=1 targets

release:
	$(MAKE) DEBUG=0 BUILDDEPENDANCIES=1 targets

targets:
	# build targets
	if [ ! -d $(TARGETDIR)/$(PLATFORM) ]; then mkdir -p $(TARGETDIR)/$(PLATFORM); fi

	@echo "Platform : $(PLATFORM)"
	@echo ""

# linux : build .a and .so
ifeq ($(PLATFORM),linux)
	$(MAKE) $(TARGETDIR)/$(PLATFORM)/libibpp.a
	$(MAKE) $(TARGETDIR)/$(PLATFORM)/libibpp_core.a
	$(MAKE) $(TARGETDIR)/$(PLATFORM)/libibpp_helper.a
	$(MAKE) $(TARGETDIR)/$(PLATFORM)/libibpp.so
	$(MAKE) $(TARGETDIR)/$(PLATFORM)/libibpp_core.so
	$(MAKE) $(TARGETDIR)/$(PLATFORM)/libibpp_helper.so
endif

$(TARGETDIR)/$(PLATFORM)/libibpp.a: $(CORE_OBJS) $(HELPER_OBJS)
	rm -f $@
	ar rv $@ $^
	ranlib $@

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/libibpp_core.a: $(CORE_OBJS)
	rm -f $@
	ar rv $@ $^
	ranlib $@

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/libibpp_helper.a: $(HELPER_OBJS)
	rm -f $@
	ar rv $@ $^
	ranlib $@

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/libibpp.so: $(CORE_OBJS) $(HELPER_OBJS)
	$(CC) $^ $(LDFLAGS) -shared -o $@ $(LIBS)

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/libibpp_core.so: $(CORE_OBJS)
	$(CC) $^ $(LDFLAGS) -shared -o $@ $(LIBS)

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/libibpp_helper.so: $(HELPER_OBJS)
	$(CC) $^ $(LDFLAGS) -shared -o $@ $(LIBS)

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/ibpp.lib: $(CORE_OBJS) $(HELPER_OBJS)
	lib -out:$@ $^

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/ibpp_core.lib: $(CORE_OBJS)
	lib -out:$@ $^

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

$(TARGETDIR)/$(PLATFORM)/ibpp_helper.lib: $(HELPER_OBJS)
	lib -out:$@ $^

	@echo ""
	@echo "$@ Build Successful"
	@echo ""

# disable internal rule
%.o: %.cpp

$(TARGETDIR)/$(PLATFORM)/%.o: %.cpp
	$(CC) $(CXXFLAGS) $(CCOUTPUT) $@ -c $<

%.d: %.cpp
	gcc $(CXXFLAGS) -M -MG $< | sed -e "s/\(.*\)\.o[ :]*/\$$\(OUTPUTDIR\)\/\1.o $@ : /" > $@

ifdef BUILDDEPENDANCIES

ifeq ($(PLATFORM),linux)
-include $(SRCS:.cpp=.d)
else
# static dependancies for non Linux builds
#   none needed
endif
endif

clean:
	rm -f tags
	rm -rf debug/$(PLATFORM)
	rm -rf release/$(PLATFORM)
	rm -rf *.d
	cd tests; $(MAKE) clean

# *************************************************
# Development Environment Support
# *************************************************

reallyclean: clean
	-rm -f WID

# make a list of files to edit
FILES:=$(HDRS) $(SRCS) $(CORE_SRCS) $(HELPER_SRCS)

edit: tags
	start_gvim Makefile $(FILES) -c "set makeprg=make\ debug"


