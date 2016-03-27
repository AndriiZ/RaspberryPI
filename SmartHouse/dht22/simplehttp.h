#ifndef simpleHttp_INCLUDED
#define simpleHttp_INCLUDED

#ifdef __cplusplus
extern "C" {
#endif

#include <string.h> /* memcpy, memset */
#include <sys/socket.h> /* socket, connect */
#include <netinet/in.h> /* struct sockaddr_in, struct sockaddr */
#include <netdb.h> /* struct hostent, gethostbyname */

void postToServer(char const* host, int port, char* message);

#ifdef __cplusplus
}
#endif
#endif
