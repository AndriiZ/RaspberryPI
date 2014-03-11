#include <iostream>
#include "./lib/ibpp/core/ibpp.h"
#include <iconv.h>

using namespace std;

std::string iconv_recode(std::string from, std::string to, std::string text);

int main()

{
	  std::string ServerName = "localhost";
	  std::string DbName = "MYDB_ZHENIA";
	  std::string UserName = "SYSDBA";
	  std::string Password = "illicive";
	  std::string Role = "ADMIN";
	  std::string Charset = "WIN1251";
	  std::string Params = "";

	  IBPP::Database db1;
	  db1 = IBPP::DatabaseFactory(ServerName, DbName, UserName, Password, Role, Charset, Params);
	  std::cout<<"Trying to connect...\r\n";
	  db1->Connect();
	  IBPP::Transaction tr1 = IBPP::TransactionFactory(db1,
							   IBPP::amRead, IBPP::ilConcurrency, IBPP::lrWait);
	  tr1->Start();
	  
	  std::cout<<"Connected. Now disconnecting...\r\n";
	  IBPP::Statement st1 = IBPP::StatementFactory(db1, tr1);
	  st1->Execute("SELECT MEM_ID, MEM_NAME FROM LINE");
	  while(st1->Fetch())
	    {
	      std::string mem_name;
	      int mem_id;
	      st1->Get(1, &mem_id);
	      st1->Get(2, mem_name);
	      std::cout<<mem_id<<'\t'<<iconv_recode("CP1251", "UTF-8", mem_name)<<std::endl;
	    }
	  
	  tr1->CommitRetain();
	  db1->Disconnect();
	  std::cout<<"Passed!\r\n";

          return 0;
}

std::string iconv_recode(std::string from, std::string to, std::string text)
{
  iconv_t cnv = iconv_open(to.c_str(), from.c_str());
  if (cnv == (iconv_t) - 1)
    {
      iconv_close(cnv);
      return "";
    }
  char *outbuf;
  if ((outbuf = (char *) malloc(text.length()*2 + 1)) == NULL)
    {
      iconv_close(cnv);
      return "";
    }
  char *ip = (char *) text.c_str(), *op = outbuf;
  size_t icount = text.length(), ocount = text.length()*2;

  if (iconv(cnv, &ip, &icount, &op, &ocount) != (size_t) - 1)
    {
      outbuf[text.length()*2 - ocount] = '\0';
      text = outbuf;
    }
  else
    {
      text = "";
    }

  free(outbuf);
  iconv_close(cnv);
  return text;
}

