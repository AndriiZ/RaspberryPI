#include <iostream>
#include "fcgio.h"
#include "libjson/libjson.h" 
#include "./lib/ibpp/core/ibpp.h"
#include <iconv.h>

using namespace std;

std::string iconv_recode(std::string from, std::string to, std::string text);
std::string db_result();

int main(void) {
  // Backup the stdio streambufs
  streambuf * cin_streambuf  = cin.rdbuf();
  streambuf * cout_streambuf = cout.rdbuf();
  streambuf * cerr_streambuf = cerr.rdbuf();

  FCGX_Request request;

  FCGX_Init();
  FCGX_InitRequest(&request, 0, 0);

  while (FCGX_Accept_r(&request) == 0) {
    fcgi_streambuf cin_fcgi_streambuf(request.in);
    fcgi_streambuf cout_fcgi_streambuf(request.out);
    fcgi_streambuf cerr_fcgi_streambuf(request.err);

    cin.rdbuf(&cin_fcgi_streambuf);
    cout.rdbuf(&cout_fcgi_streambuf);
    cerr.rdbuf(&cerr_fcgi_streambuf);


    cout << "Content-type: application/json\r\n"
	 << endl;

    auto jc = db_result();
    cout << jc << endl;

    // Note: the fcgi_streambuf destructor will auto flush
  }

  // restore stdio streambufs
  cin.rdbuf(cin_streambuf);
  cout.rdbuf(cout_streambuf);
  cerr.rdbuf(cerr_streambuf);

  return 0;
}

std::string db_result()
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
  db1->Connect();
  IBPP::Transaction tr1 = IBPP::TransactionFactory(db1,
						   IBPP::amRead, IBPP::ilConcurrency, IBPP::lrWait);
  tr1->Start();

  IBPP::Statement st1 = IBPP::StatementFactory(db1, tr1);
  st1->Execute("SELECT MEM_ID, MEM_NAME FROM LINE");
  
  JSONNode c(JSON_ARRAY);
  c.set_name("articles");

   while(st1->Fetch())
    {
      std::string mem_name;
      int mem_id;
      st1->Get(1, &mem_id);
      st1->Get(2, mem_name);
      c.push_back(JSONNode(iconv_recode("CP1251", "UTF-8", mem_name), mem_id));
   }

  tr1->CommitRetain();
  db1->Disconnect();
  return c.write_formatted();
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
