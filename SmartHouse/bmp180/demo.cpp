#include "bmp085.hpp" 
#include <iostream>
#include <cstring> 
#include <cstdio> 
#include <cerrno> 
#include "sql.cpp"
#include "ownserverapi.h"

int main()
{
  BMP085 bmp180;
  if (!bmp180.ok)
  {
    std::cerr<<bmp180.err;
    return 1;
  }
  bmp180.hiRes = true;
  auto readings = bmp180.getBoth();
  //std::cout<<readings.celcius<<std::endl;
  //std::cout<<readings.kPa<<std::endl;  
  //saveToDB(readings.celcius, readings.kPa);
  postWeather(readings.celcius, readings.kPa, "70528E8C-3467-48CD-BDD4-61D509839397");
  //std::cout<<"done"<<std::endl;
  return 0;
}
