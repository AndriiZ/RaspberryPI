#include <stdio.h>
#include <sqlite3.h>
#include <ctime>
#include <cerrno>

void usleep(unsigned msec) {
    struct timespec req, rem;
    int err;
    req.tv_sec = msec / 1000;
    req.tv_nsec = (msec % 1000) * 1000000;
    while ((req.tv_sec != 0) || (req.tv_nsec != 0)) {
        if (nanosleep(&req, &rem) == 0)
            break;
        err = errno;
        // Interrupted; continue
        if (err == EINTR) {
            req.tv_sec = rem.tv_sec;
            req.tv_nsec = rem.tv_nsec;
        }
        // Unhandleable error (EFAULT (bad pointer), EINVAL (bad timeval in tv_nsec), or ENOSYS (function not supported))
        break;
    }
}


sqlite3 *conn;

int first_row;

int select_callback(void *p_data, int num_fields, char **p_fields, char **p_col_names) {

  int i;

  int* nof_records = (int*) p_data;
  (*nof_records)++;

  if (first_row) {
    first_row = 0;

    for (i=0; i < num_fields; i++) {
      printf("%20s", p_col_names[i]);
    }

    printf("\n");
    for (i=0; i< num_fields*20; i++) {
      printf("=");
    }
    printf("\n");
  }

  for(i=0; i < num_fields; i++) {
    if (p_fields[i]) {
      printf("%20s", p_fields[i]);
    }
    else {
      printf("%20s", " ");
    }
  }

  printf("\n");
  return 0;
}

void select_stmt(const char* stmt) {
  char *errmsg;
  int   ret;
  int   nrecs = 0;

  first_row = 1;

  ret = sqlite3_exec(conn, stmt, select_callback, &nrecs, &errmsg);

  if(ret!=SQLITE_OK) {
    printf("Error in select statement %s [%s].\n", stmt, errmsg);
  }
  else {
    printf("\n   %d records returned.\n", nrecs);
  }
}

void sql_stmt(const char* stmt) {
  char *errmsg;
  int   ret;

  ret = sqlite3_exec(conn, stmt, 0, 0, &errmsg);

  if(ret != SQLITE_OK) {
    printf("Error in statement: %s [%s].\n", stmt, errmsg);
  }
}

int saveToDB(float temperature, float pressure)
{
  char *zErrMsg = 0;
  int error = 0;

  error = sqlite3_open("/home/pi/src/dht22/weather.sl3", &conn);
  if (error)
  {
   printf("Can not open database");
   return 1;
  }

  sqlite3_stmt *stmt;

  int continueTrying = 1;
  int tryCount = 0;

  while (continueTrying)
  {
    int retval =  sqlite3_prepare(
           conn,
           "insert into weather_bmp180 values (CURRENT_TIMESTAMP, ?,?)",  // stmt
          -1, // If than zero, then stmt is read up to the first nul terminator
          &stmt,
           0  // Pointer to unused portion of stmt
         );
    switch (retval) {
      case SQLITE_BUSY:
        tryCount++;
        if (tryCount > 10 * 6 * 4) {
          printf("\nDatabase busy.");
          return 1;
        }
        usleep(1000);
        break;
     case SQLITE_OK:
        continueTrying = 0;
        break;
     default:
        printf("\nCould not prepare statement.");
       return 1;
    }
  }


  if (sqlite3_bind_double(stmt,
   1,
   temperature) != SQLITE_OK) {
    printf("\nCould not bind temperature");
    return 1;
  }

  if (sqlite3_bind_double(stmt,
   2,
   pressure) != SQLITE_OK) {
    printf("\nCould not bind pressure");
    return 1;
  }

  if (sqlite3_step(stmt) != SQLITE_DONE) {
    printf("\nCould not step (execute) stmt.\n");
    return 1;
  }

  //select_stmt("select * from weather order by time desc limit 10");

  sqlite3_close(conn);
  return 0;
}
