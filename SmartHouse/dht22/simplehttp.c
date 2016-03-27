#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include <syslog.h>

#include "simplehttp.h"
#include "helper.h"

void postToServer(char const* host, int portno, char* message)
{
    struct hostent *server;
    struct sockaddr_in serv_addr;
    int sockfd, bytes, sent, received, total;
    char response[4096];
     
    //printf("Request:\n%s\n",message);

    /* create the socket */
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd < 0) 
    {
      putError("ERROR opening socket");
      return;
    }

    /* lookup the ip address */
    server = gethostbyname(host);

    if (server == NULL)
    {
      putError("ERROR  no such host");
      return;
    }


    /* fill in the structure */
    memset(&serv_addr,0,sizeof(serv_addr));
    serv_addr.sin_family = AF_INET;
    serv_addr.sin_port = htons(portno);
    memcpy(&serv_addr.sin_addr.s_addr,server->h_addr,server->h_length);

    /* connect the socket */
    if (connect(sockfd,(struct sockaddr *)&serv_addr,sizeof(serv_addr)) < 0)
    {
      putError("ERROR connecting");
      return;
    }

    /* send the request */
    total = strlen(message);
    sent = 0;
    do {
        bytes = write(sockfd,message+sent,total-sent);
        if (bytes < 0)
        {
          putError("ERROR writing message to socket");
          return;
        }

        if (bytes == 0)
            break;
        sent+=bytes;
    } while (sent < total);

    /* receive the response */
    memset(response,0,sizeof(response));
    total = sizeof(response)-1;
    received = 0;
    do {
        bytes = read(sockfd,response+received,total-received);
        if (bytes < 0)
        {
          putError("ERROR reading response from socket");
          return;
        }

        if (bytes == 0)
            break;
        received+=bytes;
    } while (received < total);

    if (received == total)
        {
          putError("ERROR storing complete response from socket");
          return;
        }

    /* close the socket */
    close(sockfd);

    /* process response */
    //printf("Response:\n%s\n",response);
}

