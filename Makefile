all:
	g++ echo-cpp.cpp -std=c++0x  -Wall -lfcgi++ -lfcgi -o hello_world -ljson -DIBPP_LINUX  -lfbclient -lcrypt -lm -lpthread -libpp