#include "helper.h"

char* stradd(const char* a, const char* b){
    size_t len = strlen(a) + strlen(b);
    char *ret = (char*)malloc(len * sizeof(char) + 1);
    *ret = '\0';
    return strcat(strcat(ret, a) ,b);
}

void putError(const char* error)
{

   fprintf(stderr, stradd(error,"\n"));
   syslog(LOG_ERR, error);
}

