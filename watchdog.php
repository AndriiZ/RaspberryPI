#!/usr/bin/php
<?php

class Switcher {

public function reboot()
{
   exec("/home/pi/src/reboot.expect");
}


function setup_curl_post($post,$address,$referer)
{
  $userAgent = 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko';
  $user = 'admin';
  $password = 'xxxxxxxxxxxxxxxxxx';

  return array(
  CURLOPT_USERAGENT => $userAgent,
  CURLOPT_POST => true, //using post
  CURLOPT_REFERER => $referer,
  CURLOPT_URL => $address,  //where to go
  CURLOPT_USERPWD => "$user:$password",
  CURLOPT_POSTFIELDS => $post, //input params
  CURLOPT_RETURNTRANSFER => true, //Returns a string value of the request
  );
}

public function switch_dns($useProviderDNS)
{
  $ch = curl_init(); //Initialize curl in $ch
  $address = 'http://192.168.1.100/cgi-bin/Advanced_DSL_Content.asp';
  $referer = 'http://192.168.1.100/cgi-bin/Advanced_DSL_Content.asp';
  
  $post = '';
  if ($useProviderDNS === TRUE)
    $post = 'productid=DSL-N16U&current_page=Advanced_DSL_Content.asp&next_page=Advanced_DSL_Content.asp&next_host=&group_id=&modified=0&action_mode=apply&action_script=restart_dslwan_if+0&action_wait=5&first_time=&preferred_lang=EN&firmver=1.0.8.6&lan_ipaddr=192.168.1.1&lan_netmask=255.255.255.0&wanSaveFlag=1&wanTransFlag=0&wanBarrierFlag=0&ptm_VC=8&wanVCFlag=3&service_num_flag=0&isDSLITESupported=1&is8021xsupport=1&isIPv6Supported=1&isPPPAuthen=Yes&PPPDHCPv6Mode_Flag=1&wan_8021q=1&disp_wan_8021q=1&DefaultWan_Active=No&DefaultWan_VPI=0&DefaultWan_VCI=33&DefaultWan_QOS=ubr&DefaultWan_PCR=0&DefaultWan_SCR=0&DefaultWan_MBS=0&DefaultWan_ISP=3&DefaultWan_ENCAP=1483+Bridged+Only+LLC&DefaultWan_IPVERSION=IPv4&DefaultWan_MLDproxy=&ipv6SupportValue=0&wan_certificate=&wan_CA=&wan_HiddenBiDirectionalAuth=&IPv6PrivacyAddrsSupportedFlag=&DvInfo_PVC=10&wan_TransMode=Ethernet&wan_TransStatus=Yes&ipVerRadio=IPv4&wanTypeOption=0&UPnP_active=No&wan_dot1q=No&wan_vid=0&wan_status=Disabled&wan_eapIdentity=&WAN_DefaultRoute=Yes&wan_TCPMTU=1492&wan_PPPGetIP=Dynamic&wan_StaticIPaddr=&wan_StaticIPSubMask=&wan_StaticIpGateway=&dnsTypeRadio=0&PrimaryDns=8.8.8.8&SecondDns=208.67.222.222&wan_NAT=Enable&wan_RIP=RIP1&wan_RIP_Dir=None&DynIPv6EnableRadio=1&PPPIPv6ModeRadio=1&PPPIPv6PDRadio=Yes&wan_IPv6Addr=&wan_IPv6Prefix=&wan_IPv6DefGw=&wan_IPv6DNS1=&wan_IPv6DNS2=&wan_MLD0=No&DSLITEEnableRadio=No&DSLITEModeRadio=0&DSLITEAddr=N%2FA&wan_PPPUsername=&wan_PPPPassword=&PPPAuthen=AUTO&wan_ConnectSelect=Connect_Keep_Alive&wan_IdleTimeT=0&wan_TCPMSS=0&wan_pppoe_options=&wan_hostname=&wan_hwaddr_x=';
  else
    $post = 'productid=DSL-N16U&current_page=Advanced_DSL_Content.asp&next_page=Advanced_DSL_Content.asp&next_host=&group_id=&modified=0&action_mode=apply&action_script=restart_dslwan_if+0&action_wait=5&first_time=&preferred_lang=EN&firmver=1.0.8.6&lan_ipaddr=192.168.1.1&lan_netmask=255.255.255.0&wanSaveFlag=1&wanTransFlag=0&wanBarrierFlag=0&ptm_VC=8&wanVCFlag=3&service_num_flag=0&isDSLITESupported=1&is8021xsupport=1&isIPv6Supported=1&isPPPAuthen=Yes&PPPDHCPv6Mode_Flag=1&wan_8021q=1&disp_wan_8021q=1&DefaultWan_Active=No&DefaultWan_VPI=0&DefaultWan_VCI=33&DefaultWan_QOS=ubr&DefaultWan_PCR=0&DefaultWan_SCR=0&DefaultWan_MBS=0&DefaultWan_ISP=3&DefaultWan_ENCAP=1483+Bridged+Only+LLC&DefaultWan_IPVERSION=IPv4&DefaultWan_MLDproxy=&ipv6SupportValue=0&wan_certificate=&wan_CA=&wan_HiddenBiDirectionalAuth=&IPv6PrivacyAddrsSupportedFlag=&DvInfo_PVC=10&wan_TransMode=Ethernet&wan_TransStatus=Yes&ipVerRadio=IPv4&wanTypeOption=0&UPnP_active=No&wan_dot1q=No&wan_vid=0&wan_status=Disabled&wan_eapIdentity=&WAN_DefaultRoute=Yes&wan_TCPMTU=1492&wan_PPPGetIP=Dynamic&wan_StaticIPaddr=&wan_StaticIPSubMask=&wan_StaticIpGateway=&dnsTypeRadio=1&PrimaryDns=8.8.8.8&SecondDns=208.67.222.222&wan_NAT=Enable&wan_RIP=RIP1&wan_RIP_Dir=None&DynIPv6EnableRadio=1&PPPIPv6ModeRadio=1&PPPIPv6PDRadio=Yes&wan_IPv6Addr=&wan_IPv6Prefix=&wan_IPv6DefGw=&wan_IPv6DNS1=&wan_IPv6DNS2=&wan_MLD0=No&DSLITEEnableRadio=No&DSLITEModeRadio=0&DSLITEAddr=N%2FA&wan_PPPUsername=&wan_PPPPassword=&PPPAuthen=AUTO&wan_ConnectSelect=Connect_Keep_Alive&wan_IdleTimeT=0&wan_TCPMSS=0&wan_pppoe_options=&wan_hostname=&wan_hwaddr_x=';
 
  $options = $this->setup_curl_post($post,$address,$referer);

  curl_setopt_array($ch, $options); //add params values to $ch
  $content = curl_exec($ch); //execute

  $this->logout($ch, $options);
  curl_close($ch);
}

public function logout($ch, $opt)
{
  $address = 'http://192.168.1.100/Logout.asp';

  $options = array(
  CURLOPT_USERAGENT => $opt[CURLOPT_USERAGENT],
  CURLOPT_POST => false, //using post
  CURLOPT_REFERER => $opt[CURLOPT_REFERER],
  CURLOPT_URL => $address,  //where to go
  CURLOPT_USERPWD => $opt[CURLOPT_USERPWD]
  );

  curl_setopt_array($ch, $options);
  curl_exec($ch);
}

public function switch_to_usb()
{
  $ch = curl_init(); //Initialize curl in $ch
  $address = 'http://192.168.1.100/cgi-bin/start_apply.asp';
  $referer = 'http://192.168.1.100/cgi-bin/Advanced_WANPort_Content.asp';

  $post = 'current_page=Advanced_WANPort_Content.asp&next_page=Advanced_Modem_Content.asp&modified=0&action_mode=apply&action_wait=30&action_script=reboot&preferred_lang=EN&firmver=1.1.0.4&wl_ssid=ASUS&wan_unit=0&wans_dualwan=usb+wan&wandog_enable=0&wans_primary=usb&wans_lanport1=1&wans_second=wan&wans_lanport2=1&wans_mode=fb&wandog_delay=0&wandog_interval=5&wandog_maxfail=12&wandog_fb_count=4&wandog_enable_radio=0&wans_FromIP_x_0=&wans_ToIP_x_0=&wans_unit_x_0=0';

  $options = $this->setup_curl_post($post,$address,$referer);

  curl_setopt_array($ch, $options); //add params values to $ch
  $content = curl_exec($ch); //execute
  $this->logout($ch, $options);
  curl_close($ch);
  return $content;
}

public function switch_to_ethernet()
{
  $ch = curl_init(); //Initialize curl in $ch
  $address = 'http://192.168.1.100/cgi-bin/start_apply.asp';
  $referer = 'http://192.168.1.100/cgi-bin/Advanced_WANPort_Content.asp';

  $post = 'current_page=Advanced_WANPort_Content.asp&next_page=Advanced_DSL_Content.asp&modified=0&action_mode=apply&action_wait=30&action_script=reboot&preferred_lang=EN&firmver=1.1.0.4&wl_ssid=ASUS&wan_unit=0&wans_dualwan=wan+usb&wandog_enable=0&wans_primary=wan&wans_lanport1=1&wans_second=usb&wans_lanport2=1&wans_mode=fb&wandog_delay=0&wandog_interval=5&wandog_maxfail=12&wandog_fb_count=4&wandog_enable_radio=0&wans_FromIP_x_0=&wans_ToIP_x_0=&wans_unit_x_0=0';

  $options = $this->setup_curl_post($post,$address,$referer);

  curl_setopt_array($ch, $options); //add params values to $ch
  $content = curl_exec($ch); //execute
  $this->logout($ch, $options);
  curl_close($ch);
  return $content;
}


function check_alive($url, $check = 0, $timeout = 10) {
  if ($check > 0)
    return 200;
  $ch = curl_init($url);

  // Set request options
  curl_setopt_array($ch, array(
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_NOBODY => true,
    CURLOPT_TIMEOUT => $timeout,
    CURLOPT_USERAGENT => 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko'
  ));

  // Execute request
  curl_exec($ch);

  // Check if an error occurred
  if(curl_errno($ch)) {
    curl_close($ch);
    return false;
  }

  // Get HTTP response code
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  // Page is alive if 200 OK is received
  return $code;
}

public function check_connection()
{
$check = 0;

$check = $this->check_alive('https://google.com') === 200 ? $check+1 : $check;
$check = $this->check_alive('https://facebook.com', $check) === 200 ? $check+1 : $check;
$check = $this->check_alive('https://twitter.com', $check) === 200 ? $check+1 : $check;
 return $check > 0;
}
}

$fp = NULL;
if (file_exists("/tmp/lock_switch_dsln16u.txt"))
{
   $fp = fopen("/tmp/lock_switch_dsln16u.txt", "r+");
}
else
{
  $fp = fopen("/tmp/lock_switch_dsln16u.txt", "w");
}

$oneinstanceflag = FALSE;

if ($fp !== FALSE)
if (flock($fp, LOCK_EX)) { // do an exclusive lock
    ftruncate($fp, 0); // truncate file
    fwrite($fp, time());
    fwrite($fp, "\n");
    $oneinstanceflag = TRUE;
} else {
    mail('zhouck@gmail.com',  'Internet connection check in progress',   'DNS state unknown');
}

if ($oneinstanceflag === TRUE)
{
$switcher = new Switcher();

$force = FALSE;
$force2 = FALSE;
$force3 = FALSE;
$force4 = FALSE;
$usbtest = FALSE;
$switchtoethernet = FALSE;
$switchtousb = FALSE;



foreach($argv as $arg)
{
  if ($arg == '-force')
    $force = TRUE;
  if ($arg == '-force2')
   {
    $force = TRUE;
    $force2 = TRUE;
   }
  if ($arg == '-force3')
  {
    $force = TRUE;
    $force2 = TRUE;
    $force3 = TRUE;
  }
  if ($arg == '-force4')
  {
    $force = TRUE;
    $force2 = TRUE;
    $force3 = TRUE;
    $force4 = TRUE;
  }
  if ($arg == '-usbtest')
  {
    $force = TRUE;
    $force2 = TRUE;
    $force3 = TRUE;
    $force4 = TRUE;
    $usbtest = TRUE;
  }
  if ($arg == '-switchtoethernet')
    $switchtoethernet = TRUE;
  if ($arg == '-switchtousb')
    $switchtousb = TRUE;
}  

$action = " none";

if ($switchtoethernet)
{
   $switcher->switch_to_ethernet();
   echo "\rSwitched to ethernet";
   exit(0);
}

if ($switchtousb)
{
   $switcher->switch_to_usb();
   echo "\rSwitched to USB";
   exit(0);
}


if ($force || $switcher->check_connection() === false)
{
   if ($force)
     echo "\nfirst attempt";
   $switcher->switch_dns(FALSE);
   sleep(5);
   $connected = $switcher->check_connection();
   $action = " one time dns switch";
   if ($force2 || !$connected)
     {
       if ($force2)
         echo "\nsecond attempt";

       $switcher->switch_dns(TRUE);
       sleep(5);
       $connected = $switcher->check_connection();
       $action = " two times dns switch";
       if ($force3 || !$connected)
       {
	 if ($force3)
	     echo "\nthird attempt";

	 $switcher->switch_dns(FALSE);
         sleep(10);
	 $switcher->switch_dns(TRUE);
	 sleep(10);
         $connected = $switcher->check_connection();
         $action = " four times dns switch";
         if ($force4 || !$connected)
         {
	   if ($force4)
	     echo "\nfourth attempt";

            if (file_exists("/tmp/reboot_switch_dsln16u.txt"))
            {
		$action = "reboot file exists, skip";
	    }
            else
            {
	     if ($force4)
                echo "\ntry to reboot";

             $fp1 = fopen("/tmp/reboot_switch_dsln16u.txt", "w");
	     fwrite($fp1, time());
	     fwrite($fp1, "\n");
	     fclose($fp1);	

	     if (!$usbtest)
	     {
               $switcher->reboot();
               sleep(60);
	     }
             $action = " reboot";
            }
            $connected = $switcher->check_connection();
	    
	    if (!$connected || $usbtest)
	    {
		if ($force)
	          echo "\nSwitch to usb...";
		$action=" switched to Intertelecom";
		$usbcontent = $switcher->switch_to_usb();
		//echo $usbcontent;
		sleep(30);
	    }
            $connected = $switcher->check_connection();

            if (!$connected)
            {
                if ($force)
                  echo "\nSwitch to ethernet...";
                $action=" switched to Lanet";
		$switcher->switch_to_ethernet();
                //echo $usbcontent;
                sleep(60);
            }
	    $connected = $switcher->check_connection();

	    if ($connected)
            {
		unlink("/tmp/reboot_switch_dsln16u.txt");
            }
         }
       }
     }
   if ($connected === true && !$force)
     mail('zhouck@gmail.com',  'Internet connection problem',   'DNS issue resolved. Action:'.$action);
   if ($force)
     echo $action;
} else {
     //$objDateTime = new DateTime('NOW');
     //mail('zhouck@gmail.com',  'Internet connection ok',   'No DNS issues '.$objDateTime->format(DateTime::ISO8601));
     if ($force)
       echo 'Internet connection ok';
} 
    flock($fp, LOCK_UN); // release the lock
}

fclose($fp);

?>
