<?php
ini_set('memory_limit', '512M');
set_time_limit(0);
// change the following paths if necessary
$yii = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yii-1.1.15' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'yii.php';
$config = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
//
require_once($yii);
include $config;

// Create connection
$conn = new mysqli('127.0.0.1', 'root', 'toor');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    require_once("SqlParser.php");

    $sql = "CREATE DATABASE  IF NOT EXISTS `comparatio_edi` /*!40100 DEFAULT CHARACTER SET latin1 */;";
    $conn->query($sql);

    $sql = "USE `comparatio_edi`;";
    $conn->query($sql);

    if (!$conn->query("DESCRIBE `bt1_bin_type`")) {
        $sql = "CREATE TABLE IF NOT EXISTS `bt1_bin_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bt1_code` varchar(20) NOT NULL,
  `bt1_desc` varchar(100) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bt1_code` (`bt1_code`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt1_bin_type`
--

LOCK TABLES `bt1_bin_type` WRITE;
/*!40000 ALTER TABLE `bt1_bin_type` DISABLE KEYS */;
INSERT INTO `bt1_bin_type` VALUES (1,'Large','',2,'2015-03-13 17:47:34',2,'2015-03-13 17:47:34',0,0),(2,'Medium','',2,'2015-03-13 17:47:50',2,'2015-03-13 17:47:50',0,0),(3,'Small','',2,'2015-03-13 17:48:02',2,'2015-03-13 17:48:02',0,0);
/*!40000 ALTER TABLE `bt1_bin_type` ENABLE KEYS */;
UNLOCK TABLES;
";
        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `co1_company`")) {
        $sql = "
--
-- Table structure for table `co1_company`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `co1_company` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `co1_type` tinyint(4) NOT NULL DEFAULT '1',
  `co1_code` varchar(10) NOT NULL DEFAULT '',
  `co1_name` varchar(250) NOT NULL DEFAULT '',
  `co1_phone` varchar(25) DEFAULT NULL,
  `co1_fax` varchar(25) DEFAULT NULL,
  `co1_url` varchar(250) DEFAULT NULL,
  `co1_logo` varchar(250) DEFAULT NULL,
  `co1_address1` varchar(250) DEFAULT NULL,
  `co1_address2` varchar(250) DEFAULT NULL,
  `co1_city` varchar(50) DEFAULT NULL,
  `st1_id` bigint(20) DEFAULT NULL,
  `co1_postal_code` varchar(25) DEFAULT NULL,
  `co1_country` varchar(50) DEFAULT NULL,
  `co1_p21_database` varchar(100) DEFAULT NULL,
  `co1_teamwork_id` bigint(20) DEFAULT NULL,
  `co1_teamwork_desk_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `co1_type` (`co1_type`),
  KEY `co1_code` (`co1_code`),
  KEY `co1_name` (`co1_name`),
  KEY `st1_id` (`st1_id`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `co1_company`
--

LOCK TABLES `co1_company` WRITE;
/*!40000 ALTER TABLE `co1_company` DISABLE KEYS */;
INSERT INTO `co1_company` VALUES (1,1,'C1000','Internal Company 1','','','','','','','',0,'','',NULL,NULL,NULL,2,'2015-02-27 17:22:48',2,'2015-02-27 21:19:18',0,0),(2,1,'C1001','Internal Company 2','','','','','','','',0,'','',NULL,NULL,NULL,2,'2015-02-27 18:58:00',2,'2015-02-27 21:19:09',0,0),(3,2,'C1002','External Company 3','','','','','','','',0,'','',NULL,NULL,NULL,2,'2015-02-27 18:58:16',2,'2015-02-27 21:18:56',0,0),(4,1,'','Comparatio USA, LLC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,66336,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(5,1,'','3M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72039,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(6,1,'','AFPWA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72043,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(7,1,'','Air Hydro',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72055,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(8,1,'','Allegis',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72056,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(9,1,'','Blackout',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72063,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(10,1,'','Circle Bolt & Nut',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72057,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(11,1,'','DM Merchandising',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72035,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(12,1,'','EDL Fasteners',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72058,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(13,1,'','Emkat',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72037,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(14,1,'','Fastenal',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,67999,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(15,1,'','Greenwich',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,66341,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(16,1,'','Nuventory',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72062,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(17,1,'','Source Atlantic',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72059,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(18,1,'','SourceOne',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,66339,NULL,1001,'2016-01-28 20:36:43',1001,'2016-01-28 20:36:43',0,0),(19,1,'','Thomas Warburton',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72060,NULL,1001,'2016-01-28 20:36:44',1001,'2016-01-28 20:36:44',0,0),(20,1,'','Unknown',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,66337,NULL,1001,'2016-01-28 20:36:44',1001,'2016-01-28 20:36:44',0,0),(21,1,'','Valley Rich Co., Inc.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,66696,NULL,1001,'2016-01-28 20:36:44',1001,'2016-01-28 20:36:44',0,0),(22,1,'','Werner Electric',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,72061,NULL,1001,'2016-01-28 20:36:44',1001,'2016-01-28 20:36:44',0,0),(23,1,'','Wurth',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,66340,NULL,1001,'2016-01-28 20:36:44',1001,'2016-01-28 20:36:44',0,0),(24,1,'','Upwork',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,98203,NULL,1,'2016-05-14 05:22:33',1,'2016-05-14 05:22:33',0,0);
/*!40000 ALTER TABLE `co1_company` ENABLE KEYS */;
UNLOCK TABLES;
";
        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `ct1_contract`")) {
        $sql = "--
-- Table structure for table `ct1_contract`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `ct1_contract` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `co1_id` bigint(20) NOT NULL,
  `cu2_id` bigint(20) NOT NULL,
  `job_price_hdr_uid` int(11) NOT NULL,
  `contract_no` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `co1_id_cu2_id_job_price_hdr_uid` (`co1_id`,`cu2_id`,`job_price_hdr_uid`),
  KEY `co1_id` (`co1_id`),
  KEY `cu2_id` (`cu2_id`),
  KEY `job_price_hdr_uid` (`job_price_hdr_uid`),
  KEY `contract_no` (`contract_no`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ct1_contract`
--

LOCK TABLES `ct1_contract` WRITE;
/*!40000 ALTER TABLE `ct1_contract` DISABLE KEYS */;
INSERT INTO `ct1_contract` VALUES (1,1,0,101,NULL,2,'2015-03-17 19:16:02',2,'2015-03-17 19:16:02',0,0),(2,1,3,320,NULL,2,'2015-03-17 19:16:02',2,'2015-03-17 19:16:02',0,0),(3,1,2,292,NULL,2,'2015-03-17 19:16:02',2,'2015-03-17 19:16:02',0,0),(4,1,7,236,NULL,2,'2015-03-17 19:16:02',2,'2015-03-17 19:16:02',0,0),(5,1,4,248,NULL,2,'2015-03-17 19:16:02',2,'2015-03-17 19:16:02',0,0),(6,1,0,328,NULL,2,'2015-03-17 19:16:02',2,'2015-03-17 19:16:02',0,0);
/*!40000 ALTER TABLE `ct1_contract` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

//    if(!$conn->query("DESCRIBE `cu1_customer`")) {
//        $sql = "--
//-- Table structure for table `cu1_customer`
//--
//
///*!40101 SET @saved_cs_client     = @@character_set_client */;
///*!40101 SET character_set_client = utf8 */;
//CREATE TABLE IF NOT EXISTS  `cu1_customer` (
//  `CU1_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `CORP_ADDRESS_ID` varchar(10) DEFAULT NULL,
//  `CU1_NAME` varchar(100) NOT NULL,
//  `CU1_CREATED_BY` int(11) NOT NULL DEFAULT '0',
//  `CU1_CREATED_ON` datetime DEFAULT NULL,
//  `CU1_MODIFIED_BY` int(11) NOT NULL DEFAULT '0',
//  `CU1_MODIFIED_ON` datetime DEFAULT NULL,
//  `CU1_SHOW_DEFAULT` varchar(1) NOT NULL DEFAULT 'X',
//  `CU1_TEST_MODE` int(11) DEFAULT '0',
//  `CU1_RECEIVE_EDI` int(11) NOT NULL DEFAULT '0',
//  `CU1_SEND_EDI_INVOICES` tinyint(3) NOT NULL DEFAULT '0',
//  `CU1_SEND_EDI_ASN` varchar(45) NOT NULL DEFAULT '0',
//  `CU1_SEND_EDI_ORDERS` tinyint(1) unsigned NOT NULL DEFAULT '0',
//  `CU1_SEND_EDI_ORDER_CONFIRMATIONS` int(11) DEFAULT '0',
//  `CU1_SEND_ACKNOWLEDGEMENT` int(11) DEFAULT '0',
//  `CU1_ORDER_TYPE` varchar(45) NOT NULL DEFAULT '0',
//  `CU1_ORDER_FORMAT` tinyint(1) unsigned DEFAULT '0',
//  `CU1_INVOICE_FORMAT` int(11) DEFAULT '0',
//  `CU1_ASN_FORMAT` int(11) DEFAULT NULL,
//  `CU1_TXT_APPROVED` int(10) NOT NULL DEFAULT '0',
//  `CU1_SEND_FTP` int(10) NOT NULL DEFAULT '0',
//  `CU1_SEND_SFTP` int(11) DEFAULT '0',
//  `CU1_POST_HTTP` int(11) NOT NULL DEFAULT '0',
//  `CU1_RECEIVE_FTP` int(10) NOT NULL DEFAULT '0',
//  `CU1_PICKUP_FTP` int(10) NOT NULL DEFAULT '0',
//  `CU1_RECEIVE_HTTP` int(11) NOT NULL DEFAULT '0',
//  `CU1_PICKUP_SFTP` int(11) DEFAULT '0',
//  `CU1_REMOTE_FTP_SERVER` varchar(200) DEFAULT NULL,
//  `CU1_REMOTE_FTP_USERNAME` varchar(200) DEFAULT NULL,
//  `CU1_REMOTE_FTP_PASSWORD` varchar(200) DEFAULT NULL,
//  `CU1_REMOTE_FTP_DIRECTORY_SEND` varchar(200) DEFAULT NULL,
//  `CU1_REMOTE_FTP_DIRECTORY_PICKUP` varchar(200) DEFAULT NULL,
//  `CU1_FTP_USER` varchar(200) DEFAULT NULL,
//  `CU1_FTP_PASSWORD` varchar(200) DEFAULT NULL,
//  `CU1_FTP_DIRECTORY` varchar(200) DEFAULT NULL,
//  `CU1_REMOTE_HTTP_SERVER` varchar(200) DEFAULT NULL,
//  `CU1_REMOTE_HTTP_USERNAME` varchar(100) DEFAULT '',
//  `CU1_REMOTE_HTTP_PASSWORD` varchar(100) DEFAULT '',
//  `CU1_SUPPLIER_CODE` varchar(45) DEFAULT NULL,
//  `CU1_RECEIVER_QUALIFIER` varchar(2) DEFAULT NULL,
//  `CU1_RECEIVER_ID` varchar(45) DEFAULT NULL,
//  `CU1_FACILITY` varchar(45) DEFAULT NULL,
//  `CU1_TRADING_PARTNER_QUALIFIER` varchar(2) DEFAULT NULL,
//  `CU1_TRADING_PARTNER_ID` varchar(45) DEFAULT NULL,
//  `CU1_ASN_TRADING_PARTNER_ID` varchar(45) DEFAULT NULL,
//  `CU1_CONSOLIDATE_ASN` int(11) DEFAULT NULL,
//  `CU1_FLAG` varchar(1) DEFAULT NULL,
//  `CU1_X12_STANDARD` varchar(4) DEFAULT NULL,
//  `CU1_EDI_VERSION` varchar(20) DEFAULT NULL,
//  `CU1_DUNS` varchar(50) DEFAULT NULL,
//  `CU1_SHARED_SECRET` varchar(100) DEFAULT NULL,
//  `CU1_REJECT_INVALID_ITEM_ORDERS` int(10) DEFAULT '0',
//  `CU1_INVALID_ITEM_SUBSTITUTE` varchar(45) DEFAULT NULL,
//  `CU1_USE_CONTRACT` int(11) DEFAULT '0',
//  `CU1_SEND_CUSTOMERS_AND_ITEMS` int(11) DEFAULT '0',
//  `CU1_STOP_IMPORT_WITH_ERRORS` int(11) DEFAULT '0',
//  `CU1_USE_CLASS_ID` int(11) DEFAULT '0',
//  `CU1_CLASS_ID` varchar(50) DEFAULT NULL,
//  `CU1_MAP` varchar(50) DEFAULT NULL,
//  `CU1_ORDER_PRICE_OVERRIDE` int(11) DEFAULT '0',
//  `CU1_SEND_CREDIT_INVOICES` int(11) DEFAULT '0',
//  `CU1_ONLY_SEND_CREDIT_INVOICES` int(11) DEFAULT '0',
//  `CU1_SEND_PAID_INVOICES` int(11) DEFAULT '0',
//  `CU1_852_IMPORT_FOLDER` varchar(255) DEFAULT NULL,
//  `CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS` int(11) DEFAULT '0',
//  `CU1_COMPLETE_SHIP_TO_NAME` int(11) DEFAULT '0',
//  `CU1_ALWAYS_SEND_ASNS` int(11) DEFAULT '0',
//  `CU1_IMPORT_FREIGHT_CODES` int(11) DEFAULT '0',
//  `CU1_POST_AS2` int(11) DEFAULT '0',
//  `CU1_RECEIVE_AS2` int(11) DEFAULT '0',
//  `CU1_CXML_PAYLOAD_ID` varchar(255) DEFAULT NULL,
//  `CU1_AS2_CERTIFICATE_FILENAME` varchar(255) DEFAULT NULL,
//  `CU1_AS2_RECEIVER_ID` varchar(255) DEFAULT NULL,
//  `CU1_AS2_TRADING_PARTNER_ID` varchar(255) DEFAULT NULL,
//  `CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID` int(11) DEFAULT '0',
//  `CU1_USE_P21_SHIP_TO_DATA` int(11) DEFAULT '0',
//  `CU1_ALLOW_DUPLICATE_PO_NUMBERS` int(11) DEFAULT '0',
//  `CU1_ALWAYS_SEND_INVOICES` int(11) DEFAULT '1',
//  `CU1_ASN_IMPORT_FOLDER` varchar(255) DEFAULT NULL,
//  `CU1_PICKUP_DIRECTORY` varchar(255) DEFAULT NULL,
//  `CU1_SEND_INVENTORY` int(11) DEFAULT '0',
//  `CU1_INVENTORY_FORMAT` int(11) DEFAULT '0',
//  `CU1_AS2_REQUEST_RECEIPT` int(11) DEFAULT '0',
//  `CU1_AS2_SIGN_MESSAGES` int(11) DEFAULT '0',
//  `CU1_AS2_KEY_LENGTH` varchar(10) DEFAULT '',
//  `CU1_AS2_ENCRYPTION_ALGORITHM` varchar(15) DEFAULT '',
//  `CU1_AS2_COMPATIBILITY_MODE` int(11) DEFAULT '0',
//  `CU1_SEND_PRICE_CATALOG` int(11) DEFAULT '0',
//  `CU1_PRICE_CATALOG_FORMAT` int(11) DEFAULT '0',
//  `CU1_ORDER_FORWARDING_FOLDER` varchar(255) DEFAULT '',
//  `CU1_PRICE_CATALOG_IMPORT_FOLDER` varchar(255) DEFAULT '',
//  `CU1_INVOICE_IMPORT_FOLDER` varchar(255) DEFAULT NULL,
//  `CU1_PICKUP_EBAY` int(11) DEFAULT '0',
//  `CU1_EBAY_TOKEN` text,
//  `CU1_EBAY_DEV_NAME` varchar(255) DEFAULT '',
//  `CU1_EBAY_APP_NAME` varchar(255) DEFAULT '',
//  `CU1_EBAY_CERT_NAME` varchar(255) DEFAULT '',
//  `CU1_SEND_EDI_PICK_TICKETS` int(11) DEFAULT '0',
//  `CU1_PICK_TICKET_FORMAT` int(11) DEFAULT '0',
//  `CU1_PICK_TICKET_LOCATION_ID` varchar(100) DEFAULT '',
//  `CU1_SAVE_867_IN_DATABASE` int(11) DEFAULT '0',
//  `CU1_SEND_ORDER_CHECK` int(11) DEFAULT '0',
//  `CU1_SHIP_TO_FILTER` varchar(100) DEFAULT '',
//  `CU1_REMOTE_FTP_DIRECTORY_SEND_INVENTORY` varchar(255) DEFAULT '',
//  `CU1_PICKUP_AMAZON` int(11) DEFAULT '0',
//  `CU1_AMAZON_MWS_MARKET_ID_US` varchar(100) DEFAULT '',
//  `CU1_AWS_ACCESS_KEY` varchar(100) DEFAULT '',
//  `CU1_AWS_SECRET_KEY` varchar(100) DEFAULT '',
//  `CU1_AWS_SELLER_ID` varchar(100) DEFAULT '',
//  `CU1_AWS_MARKETPLACE_ID` varchar(100) DEFAULT '',
//  `CU1_AWS_UTC_HOUR_OFFSET` varchar(100) DEFAULT '',
//  `CU1_PICKUP_BILLTRUST` int(11) DEFAULT '0',
//  `CU1_BILLTRUST_DEVELOPER_GUID` varchar(100) DEFAULT '',
//  `CU1_BILLTRUST_CLIENT_GUID` varchar(100) DEFAULT '',
//  `CU1_SEND_EDI_QUOTES` int(11) DEFAULT '0',
//  `CU1_QUOTE_FORMAT` int(11) DEFAULT '0',
//  `CU1_FTP_DOWNLOAD_FILTER` varchar(255) DEFAULT '',
//  `CU1_CHECK_ACKNOWLEDGEMENTS` int(11) DEFAULT '1',
//  `CU1_830_FORWARDING_FOLDER` varchar(255) DEFAULT '',
//  `CU1_PICKUP_CHANNEL_ADVISOR` int(11) DEFAULT '0',
//  `CU1_CHANNEL_ADVISOR_DEV_KEY` varchar(255) DEFAULT '',
//  `CU1_CHANNEL_ADVISOR_PASSWORD` varchar(255) DEFAULT '',
//  `CU1_CHANNEL_ADVISOR_LOCAL_ID` varchar(255) DEFAULT '',
//  `CU1_SFTP_PRIVATE_KEY_FILENAME` varchar(255) DEFAULT '',
//  `CU1_SEND_SINGLE_LINE_INVOICES` int(11) DEFAULT '0',
//  PRIMARY KEY (`CU1_ID`),
//  KEY `CU1_SHORT_CODE` (`CORP_ADDRESS_ID`),
//  KEY `CU1_NAME` (`CU1_NAME`),
//  KEY `CU1_TXT_APPROVED` (`CU1_TXT_APPROVED`),
//  KEY `CU1_SHOW_DEFAULT` (`CU1_SHOW_DEFAULT`),
//  KEY `CU1_CREATED_BY` (`CU1_CREATED_BY`),
//  KEY `CU1_CREATED_ON` (`CU1_CREATED_ON`),
//  KEY `CU1_MODIFIED_BY` (`CU1_MODIFIED_BY`),
//  KEY `CU1_MODIFIED_ON` (`CU1_MODIFIED_ON`),
//  KEY `CU1_INVOICE_TYPE_CXML` (`CU1_SEND_FTP`),
//  KEY `CU1_INVOICE_TYPE_EXCEL` (`CU1_RECEIVE_FTP`),
//  KEY `CU1_SEND_PDF_COPY` (`CU1_PICKUP_FTP`),
//  KEY `CU1_ORDER_FTP_USER` (`CU1_FTP_USER`),
//  KEY `CU1_SEND_EDI_ORDERS` (`CU1_SEND_EDI_ORDERS`),
//  KEY `CU1_ORDER_FORMAT` (`CU1_ORDER_FORMAT`)
//) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
///*!40101 SET character_set_client = @saved_cs_client */;";
//
//        file_put_contents('sqlCommand', $sql);
//        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
//        foreach ($sqlLists as $sql):
//            if ($sql != "") {
//                $conn->query($sql);
//            }
//        endforeach;
//    }

    if (!$conn->query("DESCRIBE `cu1_customer_yii`")) {
        $sql = "--
-- Table structure for table `cu1_customer_yii`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `cu1_customer_yii` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cu1_type` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_code` varchar(10) NOT NULL DEFAULT '',
  `cu1_name` varchar(250) NOT NULL DEFAULT '',
  `cu1_phone` varchar(25) DEFAULT NULL,
  `cu1_fax` varchar(25) DEFAULT NULL,
  `cu1_url` varchar(250) DEFAULT NULL,
  `cu1_logo` varchar(250) DEFAULT NULL,
  `cu1_address1` varchar(250) DEFAULT NULL,
  `cu1_address2` varchar(250) DEFAULT NULL,
  `cu1_city` varchar(50) DEFAULT NULL,
  `st1_id` bigint(20) DEFAULT NULL,
  `cu1_postal_code` varchar(25) DEFAULT NULL,
  `cu1_country` varchar(50) DEFAULT NULL,
  `cu1_duplicate_barcodes` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_split_up_orders` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_txt_approved` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_inventory_management` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_import_external_xml_usage` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_new_contract_number` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_convert_reorder_qty_into_each` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_upto_order_mode` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_show_on_hand_qty_from_p21` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_multiply_reorder_qty` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_missing_order_emails` varchar(250) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  `cu1_teamwork_desk_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`),
  KEY `cu1_code` (`cu1_code`),
  KEY `cu1_type` (`cu1_type`),
  KEY `cu1_name` (`cu1_name`),
  KEY `st1_id` (`st1_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

//    if(!$conn->query("DESCRIBE `ed1_edi`")) {
//        $sql = "--
//-- Table structure for table `ed1_edi`
//--
//
///*!40101 SET @saved_cs_client     = @@character_set_client */;
///*!40101 SET character_set_client = utf8 */;
//CREATE TABLE IF NOT EXISTS  `ed1_edi` (
//  `ED1_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
//  `ED1_TYPE` varchar(45) DEFAULT NULL,
//  `ED1_DOCUMENT_NO` varchar(50) DEFAULT '',
//  `ED1_FILENAME` varchar(255) DEFAULT NULL,
//  `ED1_STATUS` int(11) NOT NULL DEFAULT '0',
//  `CU1_ID` int(11) NOT NULL DEFAULT '0',
//  `VD1_ID` int(11) NOT NULL DEFAULT '0',
//  `ED1_MODIFIED_ON` datetime DEFAULT NULL,
//  `ED1_MODIFIED_BY` int(11) NOT NULL DEFAULT '0',
//  `ED1_CREATED_ON` datetime DEFAULT NULL,
//  `ED1_CREATED_BY` int(11) NOT NULL DEFAULT '0',
//  `ED1_SHOW_DEFAULT` varchar(1) NOT NULL DEFAULT 'X',
//  `ED1_IN_OUT` int(11) DEFAULT '0',
//  `ED1_RESEND` int(11) DEFAULT '0',
//  `ED1_ACKNOWLEDGED` int(11) DEFAULT '0',
//  `ED1_TEST_MODE` int(11) DEFAULT '0',
//  `test_column` varchar(11) DEFAULT NULL,
//  `test_date` datetime DEFAULT NULL,
//  PRIMARY KEY (`ED1_ID`),
//  KEY `CU1_ID` (`CU1_ID`),
//  KEY `VD1_ID` (`VD1_ID`),
//  KEY `ED1_STATUS` (`ED1_STATUS`),
//  KEY `ED1_DOCUMENT_NO` (`ED1_DOCUMENT_NO`),
//  KEY `ED1_IN_OUT` (`ED1_IN_OUT`),
//  KEY `ED1_RESEND` (`ED1_RESEND`),
//  KEY `ED1_TYPE` (`ED1_TYPE`)
//) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
///*!40101 SET character_set_client = @saved_cs_client */;";
//
//        file_put_contents('sqlCommand', $sql);
//        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
//        foreach ($sqlLists as $sql):
//            if ($sql != "") {
//                $conn->query($sql);
//            }
//        endforeach;
//    }

    if (!$conn->query("DESCRIBE `ed2_edi_types`")) {
        $sql = "--
-- Table structure for table `ed2_edi_types`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `ed2_edi_types` (
  `ED2_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ED2_NUMBER` int(11) NOT NULL,
  `ED2_NAME` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ED2_NUMBER`),
  UNIQUE KEY `ED2_ID_UNIQUE` (`ED2_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `em1_executive_mgt`")) {
        $sql = "--
-- Table structure for table `em1_executive_mgt`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `em1_executive_mgt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `em1_desc` varchar(250) DEFAULT NULL,
  `us1_id` bigint(20) NOT NULL,
  `lo1_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `us1_id` (`us1_id`),
  KEY `lo1_id` (`lo1_id`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `em1_executive_mgt`
--

LOCK TABLES `em1_executive_mgt` WRITE;
/*!40000 ALTER TABLE `em1_executive_mgt` DISABLE KEYS */;
INSERT INTO `em1_executive_mgt` VALUES (1,'',11,1,2,'2015-03-12 20:53:27',2,'2015-03-12 20:53:27',0,0);
/*!40000 ALTER TABLE `em1_executive_mgt` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `gr1_group`")) {
        $sql = "--
-- Table structure for table `gr1_group`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `gr1_group` (
  `GR1_ID` int(11) NOT NULL,
  `GR1_APP_NAME` text,
  `GR1_NAME` text,
  `GR1_DESC` text,
  `GR1_ACCESS` int(11) NOT NULL DEFAULT '0',
  `GR1_DELETE_FLAG` int(11) NOT NULL DEFAULT '0',
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`GR1_ID`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gr1_group`
--

LOCK TABLES `gr1_group` WRITE;
/*!40000 ALTER TABLE `gr1_group` DISABLE KEYS */;
INSERT INTO `gr1_group` VALUES (1,'TIME_REC','COMPARATIO','System Administrator',1,0,NULL,'2015-04-16 17:54:15',NULL,'0000-00-00 00:00:00',0,0),(2,'TIME_REC','ADMIN','Administrator',1,0,NULL,'2015-04-16 17:54:15',NULL,'0000-00-00 00:00:00',0,0),(3,'TIME_REC','SUPERVISOR','Supervisor',2,0,NULL,'2015-04-16 17:54:15',NULL,'0000-00-00 00:00:00',0,0),(4,'TIME_REC','USER','Standard User',0,0,NULL,'2015-04-16 17:54:15',NULL,'0000-00-00 00:00:00',0,0),(5,'TIME_REC','test','test',0,1,NULL,'2015-04-16 17:54:15',NULL,'0000-00-00 00:00:00',0,0);
/*!40000 ALTER TABLE `gr1_group` ENABLE KEYS */;
UNLOCK TABLES;
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `is1_invalid_scan`")) {
        $sql = "--
-- Table structure for table `is1_invalid_scan`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `is1_invalid_scan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `is1_error_code` tinyint(4) NOT NULL DEFAULT '0',
  `us1_id` bigint(20) NOT NULL,
  `cu1_id` bigint(20) NOT NULL,
  `or1_type` tinyint(4) NOT NULL DEFAULT '0',
  `contract_bin_id` varchar(255) NOT NULL DEFAULT '',
  `or2_scanned_qty` double NOT NULL DEFAULT '0',
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is1_error_code` (`is1_error_code`),
  KEY `us1_id` (`us1_id`),
  KEY `cu1_id` (`cu1_id`),
  KEY `or1_type` (`or1_type`),
  KEY `contract_bin_id` (`contract_bin_id`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `is1_invalid_scan`
--

LOCK TABLES `is1_invalid_scan` WRITE;
/*!40000 ALTER TABLE `is1_invalid_scan` DISABLE KEYS */;
/*!40000 ALTER TABLE `is1_invalid_scan` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

//    if(!$conn->query("DESCRIBE `lg1_log`")) {
//        $sql = "--
//-- Table structure for table `lg1_log`
//--
//
///*!40101 SET @saved_cs_client     = @@character_set_client */;
///*!40101 SET character_set_client = utf8 */;
//CREATE TABLE IF NOT EXISTS  `lg1_log` (
//  `LOG_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
//  `LOG_DESCRIPTION` text,
//  `LOG_UPDATED_BY` int(11) NOT NULL DEFAULT '0',
//  `LOG_UPDATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
//  `LOG_SHOW_DEFAULT` varchar(1) NOT NULL DEFAULT 'X',
//  `CU1_ID` int(11) NOT NULL,
//  `VD1_ID` int(11) NOT NULL,
//  `ED1_ID` int(15) NOT NULL,
//  `US1_ID` int(15) NOT NULL,
//  `LOG_FILENAME` varchar(255) DEFAULT NULL,
//  `LOG_P21` int(11) DEFAULT '0',
//  `LOG_CHECKED` int(11) DEFAULT '0',
//  `LOG_FILE_TYPE` varchar(20) DEFAULT NULL,
//  PRIMARY KEY (`LOG_ID`),
//  KEY `LOG_UPDATED_BY` (`LOG_UPDATED_BY`),
//  KEY `LOG_UPDATED_ON` (`LOG_UPDATED_ON`),
//  KEY `AD1_ID` (`VD1_ID`),
//  KEY `CO1_ID` (`ED1_ID`),
//  KEY `CU1_ID` (`US1_ID`),
//  KEY `DELETE_FLAG` (`LOG_SHOW_DEFAULT`) USING BTREE,
//  KEY `MD1_ID` (`CU1_ID`),
//  KEY `LOG_DESCRIPTION` (`LOG_DESCRIPTION`(250))
//) ENGINE=InnoDB AUTO_INCREMENT=90255 DEFAULT CHARSET=latin1;
///*!40101 SET character_set_client = @saved_cs_client */;
//
//
///*!40101 SET @saved_cs_client     = @@character_set_client */;
///*!40101 SET character_set_client = utf8 */;
//CREATE TABLE IF NOT EXISTS  `lo1_location` (
//  `id` bigint(20) NOT NULL AUTO_INCREMENT,
//  `lo1_mkey` varchar(10) DEFAULT NULL,
//  `lo1_code` varchar(10) DEFAULT NULL,
//  `lo1_name` varchar(250) DEFAULT NULL,
//  `rg1_id` bigint(20) DEFAULT NULL,
//  `us1_id` bigint(20) DEFAULT NULL,
//  `created_by` bigint(20) DEFAULT NULL,
//  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//  `modified_by` bigint(20) DEFAULT NULL,
//  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
//  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
//  PRIMARY KEY (`id`),
//  KEY `lo1_code` (`lo1_code`),
//  KEY `lo1_name` (`lo1_name`),
//  KEY `rg1_id` (`rg1_id`),
//  KEY `us1_id` (`us1_id`),
//  KEY `created_by` (`created_by`),
//  KEY `created_on` (`created_on`),
//  KEY `modified_by` (`modified_by`),
//  KEY `modified_on` (`modified_on`),
//  KEY `delete_flag` (`delete_flag`),
//  KEY `update_flag` (`update_flag`)
//) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
///*!40101 SET character_set_client = @saved_cs_client */;
//
//--
//-- Dumping data for table `lo1_location`
//--
//
//LOCK TABLES `lo1_location` WRITE;
///*!40000 ALTER TABLE `lo1_location` DISABLE KEYS */;
//INSERT INTO `lo1_location` VALUES (1,'27NNMNS1ND','105153','Boston, MA',1,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(2,'512DMZT4VM','107872','Portland, OR',3,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(3,'737KTHD1DM','100016','Chicago, IL',5,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(4,'LNGKL2EJFD','107873','PHD-Chicago',2,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(5,'MIZMWRHC8U','100005','Minneapolis, MN',3,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(6,'UJE8YJAFEN','100001','St. Louis Park, MN',4,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(7,'VDLOMM80JE','105022','Dallas, TX',1,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(8,'YL00WJOTHD','100018','Phoenix, AZ',1,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0);
///*!40000 ALTER TABLE `lo1_location` ENABLE KEYS */;
//UNLOCK TABLES;";
//
//        file_put_contents('sqlCommand', $sql);
//        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
//        foreach ($sqlLists as $sql):
//            if ($sql != "") {
//                $conn->query($sql);
//            }
//        endforeach;
//    }

    if (!$conn->query("DESCRIBE `lo1_location`")) {
        $sql = "CREATE TABLE IF NOT EXISTS  `lo1_location` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lo1_mkey` varchar(10) DEFAULT NULL,
  `lo1_code` varchar(10) DEFAULT NULL,
  `lo1_name` varchar(250) DEFAULT NULL,
  `rg1_id` bigint(20) DEFAULT NULL,
  `us1_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `lo1_code` (`lo1_code`),
  KEY `lo1_name` (`lo1_name`),
  KEY `rg1_id` (`rg1_id`),
  KEY `us1_id` (`us1_id`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lo1_location`
--

LOCK TABLES `lo1_location` WRITE;
/*!40000 ALTER TABLE `lo1_location` DISABLE KEYS */;
INSERT INTO `lo1_location` VALUES (1,'27NNMNS1ND','105153','Boston, MA',1,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(2,'512DMZT4VM','107872','Portland, OR',3,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(3,'737KTHD1DM','100016','Chicago, IL',5,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(4,'LNGKL2EJFD','107873','PHD-Chicago',2,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(5,'MIZMWRHC8U','100005','Minneapolis, MN',3,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(6,'UJE8YJAFEN','100001','St. Louis Park, MN',4,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(7,'VDLOMM80JE','105022','Dallas, TX',1,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0),(8,'YL00WJOTHD','100018','Phoenix, AZ',1,NULL,2,'2015-03-17 18:46:28',2,'2015-03-17 18:46:28',0,0);
/*!40000 ALTER TABLE `lo1_location` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

//    if(!$conn->query("DESCRIBE `no1_numbers`")) {
//        $sql = "--
//-- Table structure for table `no1_numbers`
//--
//
///*!40101 SET @saved_cs_client     = @@character_set_client */;
///*!40101 SET character_set_client = utf8 */;
//CREATE TABLE IF NOT EXISTS  `no1_numbers` (
//  `NO1_TYPE` varchar(45) NOT NULL DEFAULT '',
//  `NO1_NUMBER` varchar(45) DEFAULT NULL,
//  `CU1_ID` int(11) NOT NULL DEFAULT '0',
//  `VD1_ID` int(11) NOT NULL DEFAULT '0',
//  `NO1_TEST_MODE` int(11) NOT NULL DEFAULT '0',
//  PRIMARY KEY (`NO1_TYPE`,`CU1_ID`,`VD1_ID`,`NO1_TEST_MODE`)
//) ENGINE=InnoDB DEFAULT CHARSET=latin1;
///*!40101 SET character_set_client = @saved_cs_client */;
//";
//
//        file_put_contents('sqlCommand', $sql);
//        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
//        foreach ($sqlLists as $sql):
//            if ($sql != "") {
//                $conn->query($sql);
//            }
//        endforeach;
//    }

    if (!$conn->query("DESCRIBE `ra1_rack`")) {
        $sql = "--
-- Table structure for table `ra1_rack`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `ra1_rack` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ship_to_id` varchar(50) DEFAULT NULL,
  `ship_to_name` varchar(100) DEFAULT NULL,
  `ra1_po_number` varchar(100) DEFAULT NULL,
  `pl1_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ship_to_id` (`ship_to_id`),
  KEY `ship_to_name` (`ship_to_name`),
  KEY `pl1_id` (`pl1_id`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ra1_rack`
--

LOCK TABLES `ra1_rack` WRITE;
/*!40000 ALTER TABLE `ra1_rack` DISABLE KEYS */;
INSERT INTO `ra1_rack` VALUES (1,'102214','St. Louis Park',NULL,1,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0),(2,'102546','Eden Prairie',NULL,2,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0),(3,'105075','St. Paul',NULL,4,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0),(4,'108546','Plymouth',NULL,2,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0),(5,'109135','Minneapolis',NULL,4,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0),(6,'109136','Minnetonka',NULL,4,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0),(7,'109137','Edina',NULL,4,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0),(8,'109138','Egan',NULL,4,2,'2015-03-17 19:10:58',2,'2015-03-17 19:10:58',0,0);
/*!40000 ALTER TABLE `ra1_rack` ENABLE KEYS */;
UNLOCK TABLES;
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `rg1_region`")) {
        $sql = "--
-- Table structure for table `rg1_region`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `rg1_region` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rg1_code` varchar(10) DEFAULT NULL,
  `rg1_name` varchar(250) DEFAULT NULL,
  `co1_id` bigint(20) DEFAULT NULL,
  `us1_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rg1_code` (`rg1_code`),
  KEY `rg1_name` (`rg1_name`),
  KEY `co1_id` (`co1_id`),
  KEY `us1_id` (`us1_id`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rg1_region`
--

LOCK TABLES `rg1_region` WRITE;
/*!40000 ALTER TABLE `rg1_region` DISABLE KEYS */;
INSERT INTO `rg1_region` VALUES (1,'A349FSIF53','South',1,NULL,2,'2015-03-17 18:40:25',2,'2015-03-17 18:40:25',0,0),(2,'B1SD019MQ1','PHD-Central',2,NULL,2,'2015-03-17 18:40:25',2,'2015-03-17 18:40:25',0,0),(3,'G6G5RQSFAD','East',1,NULL,2,'2015-03-17 18:40:25',2,'2015-03-17 18:40:25',0,0),(4,'IU59DFYR2Q','Northeast',1,NULL,2,'2015-03-17 18:40:25',2,'2015-03-17 18:40:25',0,0),(5,'YAIDRGKC5M','West',1,NULL,2,'2015-03-17 18:40:25',2,'2015-03-17 18:40:25',0,0);
/*!40000 ALTER TABLE `rg1_region` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `st1_state`")) {
        $sql = "--
-- Table structure for table `st1_state`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `st1_state` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `st1_code` varchar(10) DEFAULT NULL,
  `st1_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `st1_code` (`st1_code`),
  KEY `st1_name` (`st1_name`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st1_state`
--

LOCK TABLES `st1_state` WRITE;
/*!40000 ALTER TABLE `st1_state` DISABLE KEYS */;
INSERT INTO `st1_state` VALUES (1,'AL','Alabama'),(2,'AK','Alaska'),(3,'AZ','Arizona'),(4,'AR','Arkansas'),(5,'CA','California'),(6,'CO','Colorado'),(7,'CT','Connecticut'),(8,'DE','Delaware'),(9,'DC','District of Columbia'),(10,'FL','Florida'),(11,'GA','Georgia'),(12,'HI','Hawaii'),(13,'ID','Idaho'),(14,'IL','Illinois'),(15,'IN','Indiana'),(16,'IA','Iowa'),(17,'KS','Kansas'),(18,'KY','Kentucky'),(19,'LA','Louisiana'),(20,'ME','Maine'),(21,'MT','Montana'),(22,'NE','Nebraska'),(23,'NV','Nevada'),(24,'NH','New Hampshire'),(25,'NJ','New Jersey'),(26,'NM','New Mexico'),(27,'NY','New York'),(28,'NC','North Carolina'),(29,'ND','North Dakota'),(30,'OH','Ohio'),(31,'OK','Oklahoma'),(32,'OR','Oregon'),(33,'MD','Maryland'),(34,'MA','Massachusetts'),(35,'MI','Michigan'),(36,'MN','Minnesota'),(37,'MS','Mississippi'),(38,'MO','Missouri'),(39,'PA','Pennsylvania'),(40,'RI','Rhode Island'),(41,'SC','South Carolina'),(42,'SD','South Dakota'),(43,'TN','Tennessee'),(44,'TX','Texas'),(45,'UT','Utah'),(46,'VT','Vermont'),(47,'VA','Virginia'),(48,'WA','Washington'),(49,'WV','West Virginia'),(50,'WI','Wisconsin'),(51,'WY','Wyoming');
/*!40000 ALTER TABLE `st1_state` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `su1_supplier`")) {
        $sql = "--
-- Table structure for table `su1_supplier`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `su1_supplier` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `su1_code` varchar(10) NOT NULL DEFAULT '',
  `su1_name` varchar(250) NOT NULL DEFAULT '',
  `su1_phone` varchar(25) DEFAULT NULL,
  `su1_fax` varchar(25) DEFAULT NULL,
  `su1_url` varchar(250) DEFAULT NULL,
  `su1_logo` varchar(250) DEFAULT NULL,
  `su1_address1` varchar(250) DEFAULT NULL,
  `su1_address2` varchar(250) DEFAULT NULL,
  `su1_city` varchar(50) DEFAULT NULL,
  `st1_id` bigint(20) DEFAULT NULL,
  `su1_postal_code` varchar(25) DEFAULT NULL,
  `su1_country` varchar(50) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_on` (`created_on`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`),
  KEY `su1_code` (`su1_code`),
  KEY `su1_name` (`su1_name`),
  KEY `st1_id` (`st1_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `su1_supplier`
--

LOCK TABLES `su1_supplier` WRITE;
/*!40000 ALTER TABLE `su1_supplier` DISABLE KEYS */;
INSERT INTO `su1_supplier` VALUES (1,'S01','Supplier 01','1','1','','','4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'2014-12-21 17:29:09',0,0),(2,'S02','Supplier 02','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(3,'S03','Supplier 03','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(4,'S04','Supplier 04','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(5,'S05','Supplier 05','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(6,'S06','Supplier 06','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(7,'S07','Supplier 07','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(8,'S08','Supplier 08','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(9,'S09','Supplier 09','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(10,'S10','Supplier10','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(11,'S11','Supplier 11','111-222-3333','111-222-5555','','','4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'2014-09-20 05:09:56',0,0),(12,'S12','Supplier 12','111-222-3333','111-222-5555',NULL,NULL,'4517 Minnetonka Blvd.','Suite 303','St. Louis Park',36,'55416','USA',2,'2014-08-07 20:03:31',2,'0000-00-00 00:00:00',0,0),(13,'111','111','','','','','','','',NULL,'','',2,'2014-12-16 23:38:48',2,'2014-12-16 23:38:56',1,0),(14,'111','111','','','','','','','',0,'','',2,'2015-01-25 21:20:56',2,'2015-01-25 21:24:41',1,0),(15,'22222','22222','','','','','','','',0,'','',2,'2015-01-25 21:21:18',2,'2015-01-25 21:24:57',1,0),(16,'333','333','','','','','','','',0,'','',2,'2015-01-25 21:21:32',2,'2015-01-25 21:21:52',1,0);
/*!40000 ALTER TABLE `su1_supplier` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `us1_user`")) {
        $sql = "--
-- Table structure for table `us1_user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `us1_user` (
  `US1_ID` int(11) NOT NULL AUTO_INCREMENT,
  `US1_TYPE` int(10) unsigned NOT NULL DEFAULT '0',
  `US1_LOGIN` varchar(100) DEFAULT NULL,
  `US1_PASS` varchar(200) DEFAULT NULL,
  `US1_NAME` varchar(200) DEFAULT NULL,
  `US1_EMAIL` varchar(200) DEFAULT NULL,
  `CU1_ID` int(11) DEFAULT NULL,
  `VD1_ID` int(11) DEFAULT NULL,
  `US1_CREATED_BY` varchar(10) NOT NULL DEFAULT '',
  `US1_CREATED_ON` date NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `US1_MODIFIED_BY` varchar(10) NOT NULL DEFAULT '',
  `US1_MODIFIED_ON` date NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `US1_SHOW_DEFAULT` varchar(1) NOT NULL DEFAULT 'X',
  PRIMARY KEY (`US1_ID`),
  KEY `US1_LOGIN` (`US1_LOGIN`),
  KEY `US1_PASS` (`US1_PASS`),
  KEY `US1_NAME` (`US1_NAME`),
  KEY `US1_EMAIL` (`US1_EMAIL`),
  KEY `CU1_ID` (`CU1_ID`),
  KEY `US1_SHOW_DEFAULT` (`US1_SHOW_DEFAULT`),
  KEY `US1_CREATED_BY` (`US1_CREATED_BY`),
  KEY `US1_CREATED_ON` (`US1_CREATED_ON`),
  KEY `US1_MODIFIED_BY` (`US1_MODIFIED_BY`),
  KEY `US1_MODIFIED_ON` (`US1_MODIFIED_ON`),
  KEY `US1_TYPE` (`US1_TYPE`),
  KEY `VD1_ID` (`VD1_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `us1_user`
--

LOCK TABLES `us1_user` WRITE;
/*!40000 ALTER TABLE `us1_user` DISABLE KEYS */;
INSERT INTO `us1_user` VALUES (1,9,'admin','demo','Administrator','Jan.Poehland@comparatio.com',NULL,NULL,'','0000-00-00','','0000-00-00','X'),(2,1,'user','user','User','',1,0,'1','2014-09-26','1','2014-09-26','X'),(3,2,'vendor','vendor','Vendor','',0,5,'1','2014-09-26','1','2014-09-26','X');
/*!40000 ALTER TABLE `us1_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vd1_vendor`
--";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `vd1_vendor`")) {
        $sql = "--
-- Table structure for table `vd1_vendor`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `vd1_vendor` (
  `VD1_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VENDOR_ID` varchar(10) DEFAULT NULL,
  `VD1_NAME` varchar(100) NOT NULL,
  `VD1_CREATED_BY` int(11) NOT NULL DEFAULT '0',
  `VD1_CREATED_ON` datetime DEFAULT NULL,
  `VD1_MODIFIED_BY` int(11) NOT NULL DEFAULT '0',
  `VD1_MODIFIED_ON` datetime DEFAULT NULL,
  `VD1_SHOW_DEFAULT` varchar(1) NOT NULL DEFAULT 'X',
  `VD1_TEST_MODE` int(11) DEFAULT '0',
  `VD1_RECEIVE_EDI` int(11) NOT NULL DEFAULT '0',
  `VD1_SEND_EDI_PO` tinyint(3) NOT NULL DEFAULT '0',
  `VD1_SEND_ACKNOWLEDGEMENT` int(11) DEFAULT '0',
  `VD1_PO_FORMAT` int(11) DEFAULT '0',
  `VD1_SEND_FTP` int(10) NOT NULL DEFAULT '0',
  `VD1_SEND_SFTP` int(11) DEFAULT '0',
  `VD1_POST_HTTP` int(11) NOT NULL DEFAULT '0',
  `VD1_RECEIVE_FTP` int(10) NOT NULL DEFAULT '0',
  `VD1_PICKUP_FTP` int(10) NOT NULL DEFAULT '0',
  `VD1_PICKUP_SFTP` int(11) DEFAULT '0',
  `VD1_RECEIVE_HTTP` int(11) NOT NULL DEFAULT '0',
  `VD1_REMOTE_FTP_SERVER` varchar(200) DEFAULT NULL,
  `VD1_REMOTE_FTP_USERNAME` varchar(200) DEFAULT NULL,
  `VD1_REMOTE_FTP_PASSWORD` varchar(200) DEFAULT NULL,
  `VD1_REMOTE_FTP_DIRECTORY_SEND` varchar(200) DEFAULT NULL,
  `VD1_REMOTE_FTP_DIRECTORY_PICKUP` varchar(200) DEFAULT NULL,
  `VD1_FTP_USER` varchar(200) DEFAULT NULL,
  `VD1_FTP_PASSWORD` varchar(200) DEFAULT NULL,
  `VD1_FTP_DIRECTORY` varchar(200) DEFAULT NULL,
  `VD1_REMOTE_HTTP_SERVER` varchar(200) DEFAULT NULL,
  `VD1_REMOTE_HTTP_USERNAME` varchar(100) DEFAULT '',
  `VD1_REMOTE_HTTP_PASSWORD` varchar(100) DEFAULT '',
  `VD1_SUPPLIER_CODE` varchar(45) DEFAULT NULL,
  `VD1_RECEIVER_QUALIFIER` varchar(2) DEFAULT NULL,
  `VD1_RECEIVER_ID` varchar(45) DEFAULT NULL,
  `VD1_FACILITY` varchar(45) DEFAULT NULL,
  `VD1_TRADING_PARTNER_QUALIFIER` varchar(2) DEFAULT NULL,
  `VD1_TRADING_PARTNER_ID` varchar(45) DEFAULT NULL,
  `VD1_TRADING_PARTNER_GS_ID` varchar(45) DEFAULT NULL,
  `VD1_FLAG` varchar(1) DEFAULT NULL,
  `VD1_X12_STANDARD` varchar(4) DEFAULT NULL,
  `VD1_EDI_VERSION` varchar(5) DEFAULT NULL,
  `VD1_DUNS` varchar(50) DEFAULT NULL,
  `VD1_SHARED_SECRET` varchar(100) DEFAULT NULL,
  `VD1_SEND_EDI_PO_CHANGE` int(11) DEFAULT '0',
  `VD1_SEND_ITEM_USAGE` int(11) DEFAULT '0',
  `VD1_ITEM_USAGE_FORMAT` int(11) DEFAULT '0',
  `VD1_ITEM_USAGE_SOURCE` varchar(255) DEFAULT NULL,
  `VD1_POST_AS2` int(11) DEFAULT '0',
  `VD1_RECEIVE_AS2` int(11) DEFAULT '0',
  `VD1_CHECK_P21_EDI_FLAG` int(11) DEFAULT '0',
  `VD1_CXML_PAYLOAD_ID` varchar(255) DEFAULT NULL,
  `VD1_SEND_EDI_PAYMENT_ADVICE` int(11) DEFAULT '0',
  `VD1_PAYMENT_ADVICE_FORMAT` int(11) DEFAULT '0',
  `VD1_BANK_ROUTING_NUMBER` varchar(50) DEFAULT NULL,
  `VD1_BANK_ACCOUNT_NUMBER` varchar(50) DEFAULT NULL,
  `VD1_AS2_CERTIFICATE_FILENAME` varchar(255) DEFAULT NULL,
  `VD1_AS2_RECEIVER_ID` varchar(255) DEFAULT NULL,
  `VD1_AS2_TRADING_PARTNER_ID` varchar(255) DEFAULT NULL,
  `VD1_PICKUP_DIRECTORY` varchar(255) DEFAULT NULL,
  `VD1_AS2_REQUEST_RECEIPT` int(11) DEFAULT '0',
  `VD1_AS2_SIGN_MESSAGES` int(11) DEFAULT '0',
  `VD1_AS2_KEY_LENGTH` varchar(10) DEFAULT '',
  `VD1_AS2_ENCRYPTION_ALGORITHM` varchar(15) DEFAULT '',
  `VD1_AS2_COMPATIBILITY_MODE` int(11) DEFAULT '0',
  `VD1_PAYMENT_QUALIFIER` varchar(40) DEFAULT '',
  `VD1_PAYMENT_ID` varchar(40) DEFAULT '',
  `VD1_MAP` varchar(50) DEFAULT NULL,
  `VD1_CHECK_ACKNOWLEDGEMENTS` int(11) DEFAULT '1',
  `VD1_FTP_DOWNLOAD_FILTER` varchar(255) DEFAULT '',
  `VD1_SFTP_PRIVATE_KEY_FILENAME` varchar(255) DEFAULT '',
  PRIMARY KEY (`VD1_ID`),
  KEY `CU1_SHORT_CODE` (`VENDOR_ID`),
  KEY `CU1_NAME` (`VD1_NAME`),
  KEY `CU1_SHOW_DEFAULT` (`VD1_SHOW_DEFAULT`),
  KEY `CU1_CREATED_BY` (`VD1_CREATED_BY`),
  KEY `CU1_CREATED_ON` (`VD1_CREATED_ON`),
  KEY `CU1_MODIFIED_BY` (`VD1_MODIFIED_BY`),
  KEY `CU1_MODIFIED_ON` (`VD1_MODIFIED_ON`),
  KEY `CU1_INVOICE_TYPE_CXML` (`VD1_SEND_FTP`),
  KEY `CU1_INVOICE_TYPE_EXCEL` (`VD1_RECEIVE_FTP`),
  KEY `CU1_SEND_PDF_COPY` (`VD1_PICKUP_FTP`),
  KEY `CU1_ORDER_FTP_USER` (`VD1_FTP_USER`),
  KEY `VD1_PO_FORMAT` (`VD1_PO_FORMAT`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vd1_vendor`
--
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `ve1_version`")) {
        $sql = "--
-- Table structure for table `ve1_version`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `ve1_version` (
  `VE1_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VE1_NUMBER` varchar(10) NOT NULL,
  PRIMARY KEY (`VE1_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ve1_version`
--

LOCK TABLES `ve1_version` WRITE;
/*!40000 ALTER TABLE `ve1_version` DISABLE KEYS */;
INSERT INTO `ve1_version` VALUES (1,'1.0.46');
/*!40000 ALTER TABLE `ve1_version` ENABLE KEYS */;
UNLOCK TABLES;

";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_auth_item`")) {
        $sql = "--
-- Table structure for table `yii_auth_item`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `yii_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii_auth_item`
--

LOCK TABLES `yii_auth_item` WRITE;
/*!40000 ALTER TABLE `yii_auth_item` DISABLE KEYS */;
INSERT INTO `yii_auth_item` VALUES ('AccountRep.*',1,'AccountRep.*',NULL,'N;'),('AccountRep.AjaxGet',0,'AccountRep.AjaxGet',NULL,'N;'),('AccountRep.Blog',0,'AccountRep.Blog',NULL,'N;'),('AccountRep.Create',0,'AccountRep.Create',NULL,'N;'),('AccountRep.Delete',0,'AccountRep.Delete',NULL,'N;'),('AccountRep.Dependency',0,'AccountRep.Dependency',NULL,'N;'),('AccountRep.Edit',0,'AccountRep.Edit',NULL,'N;'),('AccountRep.Export',0,'AccountRep.Export',NULL,'N;'),('AccountRep.Index',0,'AccountRep.Index',NULL,'N;'),('AccountRep.Relation',0,'AccountRep.Relation',NULL,'N;'),('AccountRep.Update',0,'AccountRep.Update',NULL,'N;'),('AccountRep.View',0,'AccountRep.View',NULL,'N;'),('Admin',2,'Administrator Role','return Yii::app()->user->isAdmin();','N;'),('Authenticated',2,'Authenticated Role (Logged In)','return !Yii::app()->user->isGuest;','N;'),('BarcodeScanner.*',1,'BarcodeScanner.*',NULL,'N;'),('BarcodeScanner.AjaxGet',0,'BarcodeScanner.AjaxGet',NULL,'N;'),('BarcodeScanner.Blog',0,'BarcodeScanner.Blog',NULL,'N;'),('BarcodeScanner.Create',0,'BarcodeScanner.Create',NULL,'N;'),('BarcodeScanner.Delete',0,'BarcodeScanner.Delete',NULL,'N;'),('BarcodeScanner.Dependency',0,'BarcodeScanner.Dependency',NULL,'N;'),('BarcodeScanner.Edit',0,'BarcodeScanner.Edit',NULL,'N;'),('BarcodeScanner.Export',0,'BarcodeScanner.Export',NULL,'N;'),('BarcodeScanner.Index',0,'BarcodeScanner.Index',NULL,'N;'),('BarcodeScanner.Relation',0,'BarcodeScanner.Relation',NULL,'N;'),('BarcodeScanner.U',1,'BarcodeScanner.U',NULL,'N;'),('BarcodeScanner.Update',0,'BarcodeScanner.Update',NULL,'N;'),('BarcodeScanner.View',0,'BarcodeScanner.View',NULL,'N;'),('BinType.*',1,'BinType.*',NULL,'N;'),('BinType.AjaxGet',0,'BinType.AjaxGet',NULL,'N;'),('BinType.Blog',0,'BinType.Blog',NULL,'N;'),('BinType.Create',0,'BinType.Create',NULL,'N;'),('BinType.Delete',0,'BinType.Delete',NULL,'N;'),('BinType.Dependency',0,'BinType.Dependency',NULL,'N;'),('BinType.Edit',0,'BinType.Edit',NULL,'N;'),('BinType.Export',0,'BinType.Export',NULL,'N;'),('BinType.Index',0,'BinType.Index',NULL,'N;'),('BinType.Relation',0,'BinType.Relation',NULL,'N;'),('BinType.Update',0,'BinType.Update',NULL,'N;'),('BinType.View',0,'BinType.View',NULL,'N;'),('Budget.*',1,'Budget',NULL,'N;'),('Budget.AjaxGet',0,'Budget.AjaxGet',NULL,'N;'),('Budget.Blog',0,'Budget.Blog',NULL,'N;'),('Budget.Create',0,'Budget.Create',NULL,'N;'),('Budget.Delete',0,'Budget.Delete',NULL,'N;'),('Budget.Dependency',0,'Budget.Dependency',NULL,'N;'),('Budget.Edit',0,'Budget.Edit',NULL,'N;'),('Budget.Export',0,'Budget.Export',NULL,'N;'),('Budget.Index',0,'Budget.Index',NULL,'N;'),('Budget.Relation',0,'Budget.Relation',NULL,'N;'),('Budget.Update',0,'Budget.Update',NULL,'N;'),('Budget.View',0,'Budget.View',NULL,'N;'),('BudgetProject.*',1,'BudgetProject.*',NULL,'N;'),('BudgetProject.AjaxGet',0,'BudgetProject.AjaxGet',NULL,'N;'),('BudgetProject.Blog',0,'BudgetProject.Blog',NULL,'N;'),('BudgetProject.Create',0,'BudgetProject.Create',NULL,'N;'),('BudgetProject.Delete',0,'BudgetProject.Delete',NULL,'N;'),('BudgetProject.Dependency',0,'BudgetProject.Dependency',NULL,'N;'),('BudgetProject.Edit',0,'BudgetProject.Edit',NULL,'N;'),('BudgetProject.Export',0,'BudgetProject.Export',NULL,'N;'),('BudgetProject.Index',0,'BudgetProject.Index',NULL,'N;'),('BudgetProject.Relation',0,'BudgetProject.Relation',NULL,'N;'),('BudgetProject.Update',0,'BudgetProject.Update',NULL,'N;'),('BudgetProject.View',0,'BudgetProject.View',NULL,'N;'),('Company.*',1,'Company.*',NULL,'N;'),('Company.AjaxGet',0,'Company.AjaxGet',NULL,'N;'),('Company.Blog',0,'Company.Blog',NULL,'N;'),('Company.Create',0,'Company.Create',NULL,'N;'),('Company.Delete',0,'Company.Delete',NULL,'N;'),('Company.Dependency',0,'Company.Dependency',NULL,'N;'),('Company.Edit',0,'Company.Edit',NULL,'N;'),('Company.Export',0,'Company.Export',NULL,'N;'),('Company.Index',0,'Company.Index',NULL,'N;'),('Company.Relation',0,'Company.Relation',NULL,'N;'),('Company.Update',0,'Company.Update',NULL,'N;'),('Company.View',0,'Company.View',NULL,'N;'),('Contract.*',1,'Contract.*',NULL,'N;'),('Contract.AjaxGet',0,'Contract.AjaxGet',NULL,'N;'),('Contract.Blog',0,'Contract.Blog',NULL,'N;'),('Contract.Create',0,'Contract.Create',NULL,'N;'),('Contract.Delete',0,'Contract.Delete',NULL,'N;'),('Contract.Dependency',0,'Contract.Dependency',NULL,'N;'),('Contract.Edit',0,'Contract.Edit',NULL,'N;'),('Contract.Export',0,'Contract.Export',NULL,'N;'),('Contract.Index',0,'Contract.Index',NULL,'N;'),('Contract.Relation',0,'Contract.Relation',NULL,'N;'),('Contract.Update',0,'Contract.Update',NULL,'N;'),('Contract.View',0,'Contract.View',NULL,'N;'),('Customer',2,'Customer Role','return Yii::app()->user->getState(\'user_type\')==User::TYPE_CUSTOMER;','N;'),('Customer.*',1,'Customer.*',NULL,'N;'),('Customer.AjaxGet',0,'Customer.AjaxGet',NULL,'N;'),('Customer.Blog',0,'Customer.Blog',NULL,'N;'),('Customer.Create',0,'Customer.Create',NULL,'N;'),('Customer.Delete',0,'Customer.Delete',NULL,'N;'),('Customer.Dependency',0,'Customer.Dependency',NULL,'N;'),('Customer.Edit',0,'Customer.Edit',NULL,'N;'),('Customer.Export',0,'Customer.Export',NULL,'N;'),('Customer.Index',0,'Customer.Index',NULL,'N;'),('Customer.R',1,'Customer.R',NULL,'N;'),('Customer.Relation',0,'Customer.Relation',NULL,'N;'),('Customer.Update',0,'Customer.Update',NULL,'N;'),('Customer.View',0,'Customer.View',NULL,'N;'),('Customer2.*',1,'Customer2.*',NULL,'N;'),('Customer2.AjaxGet',0,'Customer2.AjaxGet',NULL,'N;'),('Customer2.Blog',0,'Customer2.Blog',NULL,'N;'),('Customer2.Create',0,'Customer2.Create',NULL,'N;'),('Customer2.Delete',0,'Customer2.Delete',NULL,'N;'),('Customer2.Dependency',0,'Customer2.Dependency',NULL,'N;'),('Customer2.Edit',0,'Customer2.Edit',NULL,'N;'),('Customer2.Export',0,'Customer2.Export',NULL,'N;'),('Customer2.Index',0,'Customer2.Index',NULL,'N;'),('Customer2.Relation',0,'Customer2.Relation',NULL,'N;'),('Customer2.Update',0,'Customer2.Update',NULL,'N;'),('Customer2.View',0,'Customer2.View',NULL,'N;'),('Dash.*',1,'Dash.*',NULL,'N;'),('Dash.Dash',0,'Dash.Dash',NULL,'N;'),('Dash.Index',0,'Dash.Index',NULL,'N;'),('Dashboard.*',1,'Dashboard.*',NULL,'N;'),('Dashboard.Index',0,'Dashboard.Index',NULL,'N;'),('ExecutiveMgt.*',1,'ExecutiveMgt.*',NULL,'N;'),('ExecutiveMgt.AjaxGet',0,'ExecutiveMgt.AjaxGet',NULL,'N;'),('ExecutiveMgt.Blog',0,'ExecutiveMgt.Blog',NULL,'N;'),('ExecutiveMgt.Create',0,'ExecutiveMgt.Create',NULL,'N;'),('ExecutiveMgt.Delete',0,'ExecutiveMgt.Delete',NULL,'N;'),('ExecutiveMgt.Dependency',0,'ExecutiveMgt.Dependency',NULL,'N;'),('ExecutiveMgt.Edit',0,'ExecutiveMgt.Edit',NULL,'N;'),('ExecutiveMgt.Export',0,'ExecutiveMgt.Export',NULL,'N;'),('ExecutiveMgt.Index',0,'ExecutiveMgt.Index',NULL,'N;'),('ExecutiveMgt.Relation',0,'ExecutiveMgt.Relation',NULL,'N;'),('ExecutiveMgt.Update',0,'ExecutiveMgt.Update',NULL,'N;'),('ExecutiveMgt.View',0,'ExecutiveMgt.View',NULL,'N;'),('Guest',2,'Guest Role (Logged Out)','return Yii::app()->user->isGuest;','N;'),('Inactive',2,'Inactive Role',NULL,'N;'),('Internal',2,'Internal Role','return Yii::app()->user->getState(\'user_type\')==User::TYPE_INTERNAL;','N;'),('InvalidScan.*',1,'InvalidScan.*',NULL,'N;'),('InvalidScan.AjaxGet',0,'InvalidScan.AjaxGet',NULL,'N;'),('InvalidScan.Blog',0,'InvalidScan.Blog',NULL,'N;'),('InvalidScan.Create',0,'InvalidScan.Create',NULL,'N;'),('InvalidScan.Delete',0,'InvalidScan.Delete',NULL,'N;'),('InvalidScan.Dependency',0,'InvalidScan.Dependency',NULL,'N;'),('InvalidScan.Edit',0,'InvalidScan.Edit',NULL,'N;'),('InvalidScan.Export',0,'InvalidScan.Export',NULL,'N;'),('InvalidScan.Index',0,'InvalidScan.Index',NULL,'N;'),('InvalidScan.Relation',0,'InvalidScan.Relation',NULL,'N;'),('InvalidScan.Update',0,'InvalidScan.Update',NULL,'N;'),('InvalidScan.View',0,'InvalidScan.View',NULL,'N;'),('Location.*',1,'Location.*',NULL,'N;'),('Location.AjaxGet',0,'Location.AjaxGet',NULL,'N;'),('Location.Blog',0,'Location.Blog',NULL,'N;'),('Location.Create',0,'Location.Create',NULL,'N;'),('Location.Delete',0,'Location.Delete',NULL,'N;'),('Location.Dependency',0,'Location.Dependency',NULL,'N;'),('Location.Edit',0,'Location.Edit',NULL,'N;'),('Location.Export',0,'Location.Export',NULL,'N;'),('Location.Index',0,'Location.Index',NULL,'N;'),('Location.Relation',0,'Location.Relation',NULL,'N;'),('Location.Update',0,'Location.Update',NULL,'N;'),('Location.View',0,'Location.View',NULL,'N;'),('MasterData.*',1,'MasterData.*',NULL,'N;'),('MasterData.AjaxGet',0,'MasterData.AjaxGet',NULL,'N;'),('MasterData.Blog',0,'MasterData.Blog',NULL,'N;'),('MasterData.Create',0,'MasterData.Create',NULL,'N;'),('MasterData.Delete',0,'MasterData.Delete',NULL,'N;'),('MasterData.Dependency',0,'MasterData.Dependency',NULL,'N;'),('MasterData.Edit',0,'MasterData.Edit',NULL,'N;'),('MasterData.Export',0,'MasterData.Export',NULL,'N;'),('MasterData.Index',0,'MasterData.Index',NULL,'N;'),('MasterData.R',1,'MasterData.R',NULL,'N;'),('MasterData.Relation',0,'MasterData.Relation',NULL,'N;'),('MasterData.Update',0,'MasterData.Update',NULL,'N;'),('MasterData.View',0,'MasterData.View',NULL,'N;'),('Order.CRU',1,'Order.CRU',NULL,'N;'),('OrderHeader.*',1,'OrderHeader.*',NULL,'N;'),('OrderHeader.AjaxGet',0,'OrderHeader.AjaxGet',NULL,'N;'),('OrderHeader.Blog',0,'OrderHeader.Blog',NULL,'N;'),('OrderHeader.Create',0,'OrderHeader.Create',NULL,'N;'),('OrderHeader.Delete',0,'OrderHeader.Delete',NULL,'N;'),('OrderHeader.Dependency',0,'OrderHeader.Dependency',NULL,'N;'),('OrderHeader.Edit',0,'OrderHeader.Edit',NULL,'N;'),('OrderHeader.Export',0,'OrderHeader.Export',NULL,'N;'),('OrderHeader.Index',0,'OrderHeader.Index',NULL,'N;'),('OrderHeader.Relation',0,'OrderHeader.Relation',NULL,'N;'),('OrderHeader.Update',0,'OrderHeader.Update',NULL,'N;'),('OrderHeader.View',0,'OrderHeader.View',NULL,'N;'),('OrderLine.*',1,'OrderLine.*',NULL,'N;'),('OrderLine.AjaxGet',0,'OrderLine.AjaxGet',NULL,'N;'),('OrderLine.Blog',0,'OrderLine.Blog',NULL,'N;'),('OrderLine.Create',0,'OrderLine.Create',NULL,'N;'),('OrderLine.Delete',0,'OrderLine.Delete',NULL,'N;'),('OrderLine.Dependency',0,'OrderLine.Dependency',NULL,'N;'),('OrderLine.Edit',0,'OrderLine.Edit',NULL,'N;'),('OrderLine.Export',0,'OrderLine.Export',NULL,'N;'),('OrderLine.Index',0,'OrderLine.Index',NULL,'N;'),('OrderLine.Relation',0,'OrderLine.Relation',NULL,'N;'),('OrderLine.Update',0,'OrderLine.Update',NULL,'N;'),('OrderLine.View',0,'OrderLine.View',NULL,'N;'),('P21Address.*',1,'P21Address.*',NULL,'N;'),('P21Address.AjaxGet',0,'P21Address.AjaxGet',NULL,'N;'),('P21Address.Blog',0,'P21Address.Blog',NULL,'N;'),('P21Address.Create',0,'P21Address.Create',NULL,'N;'),('P21Address.Delete',0,'P21Address.Delete',NULL,'N;'),('P21Address.Dependency',0,'P21Address.Dependency',NULL,'N;'),('P21Address.Edit',0,'P21Address.Edit',NULL,'N;'),('P21Address.Export',0,'P21Address.Export',NULL,'N;'),('P21Address.Index',0,'P21Address.Index',NULL,'N;'),('P21Address.Relation',0,'P21Address.Relation',NULL,'N;'),('P21Address.Update',0,'P21Address.Update',NULL,'N;'),('P21Address.View',0,'P21Address.View',NULL,'N;'),('Plant.*',1,'Plant.*',NULL,'N;'),('Plant.AjaxGet',0,'Plant.AjaxGet',NULL,'N;'),('Plant.Blog',0,'Plant.Blog',NULL,'N;'),('Plant.Create',0,'Plant.Create',NULL,'N;'),('Plant.Delete',0,'Plant.Delete',NULL,'N;'),('Plant.Dependency',0,'Plant.Dependency',NULL,'N;'),('Plant.Edit',0,'Plant.Edit',NULL,'N;'),('Plant.Export',0,'Plant.Export',NULL,'N;'),('Plant.Index',0,'Plant.Index',NULL,'N;'),('Plant.Relation',0,'Plant.Relation',NULL,'N;'),('Plant.Update',0,'Plant.Update',NULL,'N;'),('Plant.View',0,'Plant.View',NULL,'N;'),('ProductFamily.*',1,'ProductFamily.*',NULL,'N;'),('ProductFamily.AjaxGet',0,'ProductFamily.AjaxGet',NULL,'N;'),('ProductFamily.Blog',0,'ProductFamily.Blog',NULL,'N;'),('ProductFamily.Create',0,'ProductFamily.Create',NULL,'N;'),('ProductFamily.Delete',0,'ProductFamily.Delete',NULL,'N;'),('ProductFamily.Dependency',0,'ProductFamily.Dependency',NULL,'N;'),('ProductFamily.Edit',0,'ProductFamily.Edit',NULL,'N;'),('ProductFamily.Export',0,'ProductFamily.Export',NULL,'N;'),('ProductFamily.Index',0,'ProductFamily.Index',NULL,'N;'),('ProductFamily.Relation',0,'ProductFamily.Relation',NULL,'N;'),('ProductFamily.Update',0,'ProductFamily.Update',NULL,'N;'),('ProductFamily.View',0,'ProductFamily.View',NULL,'N;'),('Project.*',1,'Project.*',NULL,'N;'),('Project.AjaxGet',0,'Project.AjaxGet',NULL,'N;'),('Project.Blog',0,'Project.Blog',NULL,'N;'),('Project.Create',0,'Project.Create',NULL,'N;'),('Project.Delete',0,'Project.Delete',NULL,'N;'),('Project.Dependency',0,'Project.Dependency',NULL,'N;'),('Project.Edit',0,'Project.Edit',NULL,'N;'),('Project.Export',0,'Project.Export',NULL,'N;'),('Project.Index',0,'Project.Index',NULL,'N;'),('Project.Relation',0,'Project.Relation',NULL,'N;'),('Project.Update',0,'Project.Update',NULL,'N;'),('Project.View',0,'Project.View',NULL,'N;'),('Rack.*',1,'Rack.*',NULL,'N;'),('Rack.AjaxGet',0,'Rack.AjaxGet',NULL,'N;'),('Rack.Blog',0,'Rack.Blog',NULL,'N;'),('Rack.Create',0,'Rack.Create',NULL,'N;'),('Rack.Delete',0,'Rack.Delete',NULL,'N;'),('Rack.Dependency',0,'Rack.Dependency',NULL,'N;'),('Rack.Edit',0,'Rack.Edit',NULL,'N;'),('Rack.Export',0,'Rack.Export',NULL,'N;'),('Rack.Index',0,'Rack.Index',NULL,'N;'),('Rack.Relation',0,'Rack.Relation',NULL,'N;'),('Rack.Update',0,'Rack.Update',NULL,'N;'),('Rack.View',0,'Rack.View',NULL,'N;'),('Record.*',1,'Record.*',NULL,'N;'),('Record.AjaxCreate',0,'Record.AjaxCreate',NULL,'N;'),('Record.AjaxGet',0,'Record.AjaxGet',NULL,'N;'),('Record.Blog',0,'Record.Blog',NULL,'N;'),('Record.Create',0,'Record.Create',NULL,'N;'),('Record.Delete',0,'Record.Delete',NULL,'N;'),('Record.Dependency',0,'Record.Dependency',NULL,'N;'),('Record.Edit',0,'Record.Edit',NULL,'N;'),('Record.Export',0,'Record.Export',NULL,'N;'),('Record.Index',0,'Record.Index',NULL,'N;'),('Record.NiceGrid',0,'Record.NiceGrid',NULL,'N;'),('Record.Relation',0,'Record.Relation',NULL,'N;'),('Record.Update',0,'Record.Update',NULL,'N;'),('Record.View',0,'Record.View',NULL,'N;'),('Region.*',1,'Region.*',NULL,'N;'),('Region.AjaxGet',0,'Region.AjaxGet',NULL,'N;'),('Region.Blog',0,'Region.Blog',NULL,'N;'),('Region.Create',0,'Region.Create',NULL,'N;'),('Region.Delete',0,'Region.Delete',NULL,'N;'),('Region.Dependency',0,'Region.Dependency',NULL,'N;'),('Region.Edit',0,'Region.Edit',NULL,'N;'),('Region.Export',0,'Region.Export',NULL,'N;'),('Region.Index',0,'Region.Index',NULL,'N;'),('Region.Relation',0,'Region.Relation',NULL,'N;'),('Region.Update',0,'Region.Update',NULL,'N;'),('Region.View',0,'Region.View',NULL,'N;'),('Supplier',2,'Supplier Role','return Yii::app()->user->getState(\'user_type\')==User::TYPE_SUPPLIER;','N;'),('Supplier.*',1,'Supplier.*',NULL,'N;'),('Supplier.AjaxGet',0,'Supplier.AjaxGet',NULL,'N;'),('Supplier.Blog',0,'Supplier.Blog',NULL,'N;'),('Supplier.Create',0,'Supplier.Create',NULL,'N;'),('Supplier.Delete',0,'Supplier.Delete',NULL,'N;'),('Supplier.Dependency',0,'Supplier.Dependency',NULL,'N;'),('Supplier.Edit',0,'Supplier.Edit',NULL,'N;'),('Supplier.Export',0,'Supplier.Export',NULL,'N;'),('Supplier.Index',0,'Supplier.Index',NULL,'N;'),('Supplier.Relation',0,'Supplier.Relation',NULL,'N;'),('Supplier.Update',0,'Supplier.Update',NULL,'N;'),('Supplier.View',0,'Supplier.View',NULL,'N;'),('TableLog.*',1,'TableLog.*',NULL,'N;'),('TableLog.Blog',0,'TableLog.Blog',NULL,'N;'),('TableLog.Create',0,'TableLog.Create',NULL,'N;'),('TableLog.Delete',0,'TableLog.Delete',NULL,'N;'),('TableLog.Dependency',0,'TableLog.Dependency',NULL,'N;'),('TableLog.Edit',0,'TableLog.Edit',NULL,'N;'),('TableLog.Export',0,'TableLog.Export',NULL,'N;'),('TableLog.Index',0,'TableLog.Index',NULL,'N;'),('TableLog.R',1,'TableLog.R',NULL,'N;'),('TableLog.Relation',0,'TableLog.Relation',NULL,'N;'),('TableLog.Update',0,'TableLog.Update',NULL,'N;'),('TableLog.View',0,'TableLog.View',NULL,'N;'),('User.Profile.*',1,'User.Profile.*',NULL,'N;'),('User.Profile.Changepassword',0,'User.Profile.Changepassword',NULL,'N;'),('User.Profile.Update',0,'User.Profile.Update',NULL,'N;'),('User.Profile.View',0,'User.Profile.View',NULL,'N;'),('User.ProfileField.*',1,'User.ProfileField.*',NULL,'N;'),('User.ProfileField.Create',0,'User.ProfileField.Create',NULL,'N;'),('User.ProfileField.Delete',0,'User.ProfileField.Delete',NULL,'N;'),('User.ProfileField.Export',0,'User.ProfileField.Export',NULL,'N;'),('User.ProfileField.Index',0,'User.ProfileField.Index',NULL,'N;'),('User.ProfileField.Update',0,'User.ProfileField.Update',NULL,'N;'),('User.ProfileField.View',0,'User.ProfileField.View',NULL,'N;'),('User.User.*',1,'User.User.*',NULL,'N;'),('User.User.AjaxGet',0,'User.User.AjaxGet',NULL,'N;'),('User.User.Create',0,'User.User.Create',NULL,'N;'),('User.User.CRU',1,'User.User.CRU',NULL,'N;'),('User.User.Delete',0,'User.User.Delete',NULL,'N;'),('User.User.Dependency',0,'User.User.Dependency',NULL,'N;'),('User.User.Edit',0,'User.User.Edit',NULL,'N;'),('User.User.Export',0,'User.User.Export',NULL,'N;'),('User.User.Index',0,'User.User.Index',NULL,'N;'),('User.User.R',1,'User.User.R',NULL,'N;'),('User.User.Relation',0,'User.User.Relation',NULL,'N;'),('User.User.Update',0,'User.User.Update',NULL,'N;'),('User.User.View',0,'User.User.View',NULL,'N;'),('User.UserLog.*',1,'User.UserLog.*',NULL,'N;'),('User.UserLog.Dependency',0,'User.UserLog.Dependency',NULL,'N;'),('User.UserLog.Export',0,'User.UserLog.Export',NULL,'N;'),('User.UserLog.Index',0,'User.UserLog.Index',NULL,'N;');
/*!40000 ALTER TABLE `yii_auth_item` ENABLE KEYS */;
UNLOCK TABLES;
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_auth_item_child`")) {
        $sql = "--
-- Table structure for table `yii_auth_item_child`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `yii_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `yii_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yii_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yii_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yii_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii_auth_item_child`
--

LOCK TABLES `yii_auth_item_child` WRITE;
/*!40000 ALTER TABLE `yii_auth_item_child` DISABLE KEYS */;
INSERT INTO `yii_auth_item_child` VALUES ('Internal','AccountRep.*'),('AccountRep.*','AccountRep.AjaxGet'),('AccountRep.*','AccountRep.Blog'),('AccountRep.*','AccountRep.Create'),('AccountRep.*','AccountRep.Delete'),('AccountRep.*','AccountRep.Dependency'),('AccountRep.*','AccountRep.Edit'),('AccountRep.*','AccountRep.Export'),('AccountRep.*','AccountRep.Index'),('AccountRep.*','AccountRep.Relation'),('AccountRep.*','AccountRep.Update'),('AccountRep.*','AccountRep.View'),('Customer','Authenticated'),('Inactive','Authenticated'),('Internal','Authenticated'),('Supplier','Authenticated'),('Internal','BarcodeScanner.*'),('BarcodeScanner.*','BarcodeScanner.AjaxGet'),('BarcodeScanner.*','BarcodeScanner.Blog'),('BarcodeScanner.*','BarcodeScanner.Create'),('BarcodeScanner.*','BarcodeScanner.Delete'),('BarcodeScanner.*','BarcodeScanner.Dependency'),('BarcodeScanner.*','BarcodeScanner.Edit'),('BarcodeScanner.*','BarcodeScanner.Export'),('BarcodeScanner.*','BarcodeScanner.Index'),('BarcodeScanner.*','BarcodeScanner.Relation'),('Authenticated','BarcodeScanner.U'),('BarcodeScanner.*','BarcodeScanner.Update'),('BarcodeScanner.U','BarcodeScanner.Update'),('BarcodeScanner.*','BarcodeScanner.View'),('Internal','BinType.*'),('BinType.*','BinType.AjaxGet'),('BinType.*','BinType.Blog'),('BinType.*','BinType.Create'),('BinType.*','BinType.Delete'),('BinType.*','BinType.Dependency'),('BinType.*','BinType.Edit'),('BinType.*','BinType.Export'),('BinType.*','BinType.Index'),('BinType.*','BinType.Relation'),('BinType.*','BinType.Update'),('BinType.*','BinType.View'),('Authenticated','Budget.*'),('Budget.*','Budget.AjaxGet'),('Budget.*','Budget.Blog'),('Budget.*','Budget.Create'),('Budget.*','Budget.Delete'),('Budget.*','Budget.Dependency'),('Budget.*','Budget.Edit'),('Budget.*','Budget.Export'),('Budget.*','Budget.Index'),('Budget.*','Budget.Relation'),('Budget.*','Budget.Update'),('Budget.*','Budget.View'),('Authenticated','BudgetProject.*'),('BudgetProject.*','BudgetProject.AjaxGet'),('BudgetProject.*','BudgetProject.Blog'),('BudgetProject.*','BudgetProject.Create'),('BudgetProject.*','BudgetProject.Delete'),('BudgetProject.*','BudgetProject.Dependency'),('BudgetProject.*','BudgetProject.Edit'),('BudgetProject.*','BudgetProject.Export'),('BudgetProject.*','BudgetProject.Index'),('BudgetProject.*','BudgetProject.Relation'),('BudgetProject.*','BudgetProject.Update'),('BudgetProject.*','BudgetProject.View'),('Internal','Company.*'),('Company.*','Company.AjaxGet'),('Company.*','Company.Blog'),('Company.*','Company.Create'),('Company.*','Company.Delete'),('Company.*','Company.Dependency'),('Company.*','Company.Edit'),('Company.*','Company.Export'),('Company.*','Company.Index'),('Company.*','Company.Relation'),('Company.*','Company.Update'),('Company.*','Company.View'),('Internal','Contract.*'),('Contract.*','Contract.AjaxGet'),('Contract.*','Contract.Blog'),('Contract.*','Contract.Create'),('Contract.*','Contract.Delete'),('Contract.*','Contract.Dependency'),('Contract.*','Contract.Edit'),('Contract.*','Contract.Export'),('Contract.*','Contract.Index'),('Contract.*','Contract.Relation'),('Contract.*','Contract.Update'),('Contract.*','Contract.View'),('Internal','Customer'),('Internal','Customer.*'),('Customer.*','Customer.AjaxGet'),('Customer.R','Customer.AjaxGet'),('Customer.*','Customer.Blog'),('Customer.*','Customer.Create'),('Customer.*','Customer.Delete'),('Customer.*','Customer.Dependency'),('Customer.*','Customer.Edit'),('Customer.*','Customer.Export'),('Customer.*','Customer.Index'),('Customer.*','Customer.Relation'),('Customer.R','Customer.Relation'),('Customer.*','Customer.Update'),('Customer.*','Customer.View'),('Internal','Customer2.*'),('Customer2.*','Customer2.AjaxGet'),('Customer2.*','Customer2.Blog'),('Customer2.*','Customer2.Create'),('Customer2.*','Customer2.Delete'),('Customer2.*','Customer2.Dependency'),('Customer2.*','Customer2.Edit'),('Customer2.*','Customer2.Export'),('Customer2.*','Customer2.Index'),('Customer2.*','Customer2.Relation'),('Customer2.*','Customer2.Update'),('Customer2.*','Customer2.View'),('Authenticated','Dash.*'),('Customer','Dash.*'),('Authenticated','Dash.Dash'),('Customer','Dash.Dash'),('Authenticated','Dash.Index'),('Authenticated','Dashboard.*'),('Dashboard.*','Dashboard.Index'),('Internal','ExecutiveMgt.*'),('ExecutiveMgt.*','ExecutiveMgt.AjaxGet'),('ExecutiveMgt.*','ExecutiveMgt.Blog'),('ExecutiveMgt.*','ExecutiveMgt.Create'),('ExecutiveMgt.*','ExecutiveMgt.Delete'),('ExecutiveMgt.*','ExecutiveMgt.Dependency'),('ExecutiveMgt.*','ExecutiveMgt.Edit'),('ExecutiveMgt.*','ExecutiveMgt.Export'),('ExecutiveMgt.*','ExecutiveMgt.Index'),('ExecutiveMgt.*','ExecutiveMgt.Relation'),('ExecutiveMgt.*','ExecutiveMgt.Update'),('ExecutiveMgt.*','ExecutiveMgt.View'),('Authenticated','InvalidScan.*'),('InvalidScan.*','InvalidScan.AjaxGet'),('InvalidScan.*','InvalidScan.Blog'),('InvalidScan.*','InvalidScan.Create'),('InvalidScan.*','InvalidScan.Delete'),('InvalidScan.*','InvalidScan.Dependency'),('InvalidScan.*','InvalidScan.Edit'),('InvalidScan.*','InvalidScan.Export'),('InvalidScan.*','InvalidScan.Index'),('InvalidScan.*','InvalidScan.Relation'),('InvalidScan.*','InvalidScan.Update'),('InvalidScan.*','InvalidScan.View'),('Internal','Location.*'),('Location.*','Location.AjaxGet'),('Location.*','Location.Blog'),('Location.*','Location.Create'),('Location.*','Location.Delete'),('Location.*','Location.Dependency'),('Location.*','Location.Edit'),('Location.*','Location.Export'),('Location.*','Location.Index'),('Location.*','Location.Relation'),('Location.*','Location.Update'),('Location.*','Location.View'),('Internal','MasterData.*'),('MasterData.*','MasterData.AjaxGet'),('MasterData.R','MasterData.AjaxGet'),('MasterData.*','MasterData.Blog'),('MasterData.*','MasterData.Create'),('MasterData.*','MasterData.Delete'),('MasterData.*','MasterData.Dependency'),('MasterData.R','MasterData.Dependency'),('MasterData.*','MasterData.Edit'),('MasterData.*','MasterData.Export'),('MasterData.*','MasterData.Index'),('MasterData.R','MasterData.Index'),('Authenticated','MasterData.R'),('MasterData.*','MasterData.Relation'),('MasterData.R','MasterData.Relation'),('MasterData.*','MasterData.Update'),('MasterData.*','MasterData.View'),('MasterData.R','MasterData.View'),('Authenticated','Order.CRU'),('Internal','OrderHeader.*'),('Order.CRU','OrderHeader.AjaxGet'),('OrderHeader.*','OrderHeader.AjaxGet'),('Order.CRU','OrderHeader.Blog'),('OrderHeader.*','OrderHeader.Blog'),('Order.CRU','OrderHeader.Create'),('OrderHeader.*','OrderHeader.Create'),('OrderHeader.*','OrderHeader.Delete'),('Order.CRU','OrderHeader.Dependency'),('OrderHeader.*','OrderHeader.Dependency'),('Order.CRU','OrderHeader.Edit'),('OrderHeader.*','OrderHeader.Edit'),('Order.CRU','OrderHeader.Export'),('OrderHeader.*','OrderHeader.Export'),('Order.CRU','OrderHeader.Index'),('OrderHeader.*','OrderHeader.Index'),('Order.CRU','OrderHeader.Relation'),('OrderHeader.*','OrderHeader.Relation'),('Order.CRU','OrderHeader.Update'),('OrderHeader.*','OrderHeader.Update'),('Order.CRU','OrderHeader.View'),('OrderHeader.*','OrderHeader.View'),('Authenticated','OrderLine.*'),('Internal','OrderLine.*'),('OrderLine.*','OrderLine.AjaxGet'),('OrderLine.*','OrderLine.Blog'),('OrderLine.*','OrderLine.Create'),('OrderLine.*','OrderLine.Delete'),('OrderLine.*','OrderLine.Dependency'),('OrderLine.*','OrderLine.Edit'),('OrderLine.*','OrderLine.Export'),('OrderLine.*','OrderLine.Index'),('OrderLine.*','OrderLine.Relation'),('OrderLine.*','OrderLine.Update'),('OrderLine.*','OrderLine.View'),('Internal','P21Address.*'),('P21Address.*','P21Address.AjaxGet'),('P21Address.*','P21Address.Blog'),('P21Address.*','P21Address.Dependency'),('P21Address.*','P21Address.Index'),('P21Address.*','P21Address.Relation'),('P21Address.*','P21Address.View'),('Internal','Plant.*'),('Plant.*','Plant.AjaxGet'),('Plant.*','Plant.Blog'),('Plant.*','Plant.Create'),('Plant.*','Plant.Delete'),('Plant.*','Plant.Dependency'),('Plant.*','Plant.Edit'),('Plant.*','Plant.Export'),('Plant.*','Plant.Index'),('Plant.*','Plant.Relation'),('Plant.*','Plant.Update'),('Plant.*','Plant.View'),('Internal','ProductFamily.*'),('ProductFamily.*','ProductFamily.AjaxGet'),('ProductFamily.*','ProductFamily.Blog'),('ProductFamily.*','ProductFamily.Create'),('ProductFamily.*','ProductFamily.Delete'),('ProductFamily.*','ProductFamily.Dependency'),('ProductFamily.*','ProductFamily.Edit'),('ProductFamily.*','ProductFamily.Export'),('ProductFamily.*','ProductFamily.Index'),('ProductFamily.*','ProductFamily.Relation'),('ProductFamily.*','ProductFamily.Update'),('ProductFamily.*','ProductFamily.View'),('Authenticated','Project.*'),('Project.*','Project.AjaxGet'),('Project.*','Project.Blog'),('Project.*','Project.Create'),('Project.*','Project.Delete'),('Project.*','Project.Dependency'),('Project.*','Project.Edit'),('Project.*','Project.Export'),('Project.*','Project.Index'),('Project.*','Project.Relation'),('Project.*','Project.Update'),('Project.*','Project.View'),('Internal','Rack.*'),('Rack.*','Rack.AjaxGet'),('Rack.*','Rack.Blog'),('Rack.*','Rack.Create'),('Rack.*','Rack.Delete'),('Rack.*','Rack.Dependency'),('Rack.*','Rack.Edit'),('Rack.*','Rack.Export'),('Rack.*','Rack.Index'),('Rack.*','Rack.Relation'),('Rack.*','Rack.Update'),('Rack.*','Rack.View'),('Internal','Record.*'),('Record.*','Record.AjaxCreate'),('Record.*','Record.AjaxGet'),('Record.*','Record.Blog'),('Record.*','Record.Create'),('Record.*','Record.Delete'),('Record.*','Record.Dependency'),('Record.*','Record.Edit'),('Record.*','Record.Export'),('Record.*','Record.Index'),('Record.*','Record.NiceGrid'),('Record.*','Record.Relation'),('Record.*','Record.Update'),('Record.*','Record.View'),('Internal','Region.*'),('Region.*','Region.AjaxGet'),('Region.*','Region.Blog'),('Region.*','Region.Create'),('Region.*','Region.Delete'),('Region.*','Region.Dependency'),('Region.*','Region.Edit'),('Region.*','Region.Export'),('Region.*','Region.Index'),('Region.*','Region.Relation'),('Region.*','Region.Update'),('Region.*','Region.View'),('Internal','Supplier.*'),('Supplier.*','Supplier.AjaxGet'),('Supplier.*','Supplier.Blog'),('Supplier.*','Supplier.Create'),('Supplier.*','Supplier.Delete'),('Supplier.*','Supplier.Dependency'),('Supplier.*','Supplier.Edit'),('Supplier.*','Supplier.Export'),('Supplier.*','Supplier.Index'),('Supplier.*','Supplier.Relation'),('Supplier.*','Supplier.Update'),('Supplier.*','Supplier.View'),('TableLog.*','TableLog.Blog'),('TableLog.*','TableLog.Create'),('TableLog.*','TableLog.Delete'),('TableLog.*','TableLog.Dependency'),('TableLog.R','TableLog.Dependency'),('TableLog.*','TableLog.Edit'),('TableLog.*','TableLog.Export'),('TableLog.*','TableLog.Index'),('Authenticated','TableLog.R'),('TableLog.*','TableLog.Relation'),('TableLog.*','TableLog.Update'),('TableLog.*','TableLog.View'),('Authenticated','User.Profile.*'),('User.Profile.*','User.Profile.Changepassword'),('User.Profile.*','User.Profile.Update'),('User.Profile.*','User.Profile.View'),('User.ProfileField.*','User.ProfileField.Create'),('User.ProfileField.*','User.ProfileField.Delete'),('User.ProfileField.*','User.ProfileField.Export'),('User.ProfileField.*','User.ProfileField.Index'),('User.ProfileField.*','User.ProfileField.Update'),('User.ProfileField.*','User.ProfileField.View'),('User.User.*','User.User.AjaxGet'),('User.User.CRU','User.User.AjaxGet'),('User.User.R','User.User.AjaxGet'),('User.User.*','User.User.Create'),('User.User.CRU','User.User.Create'),('Internal','User.User.CRU'),('User.User.*','User.User.Delete'),('User.User.*','User.User.Dependency'),('User.User.CRU','User.User.Dependency'),('User.User.*','User.User.Edit'),('User.User.CRU','User.User.Edit'),('User.User.*','User.User.Export'),('User.User.CRU','User.User.Export'),('User.User.*','User.User.Index'),('User.User.CRU','User.User.Index'),('Authenticated','User.User.R'),('User.User.*','User.User.Relation'),('User.User.CRU','User.User.Relation'),('User.User.R','User.User.Relation'),('User.User.*','User.User.Update'),('User.User.CRU','User.User.Update'),('User.User.*','User.User.View'),('User.User.CRU','User.User.View'),('Internal','User.UserLog.*'),('User.UserLog.*','User.UserLog.Dependency'),('User.UserLog.*','User.UserLog.Export'),('User.UserLog.*','User.UserLog.Index');
/*!40000 ALTER TABLE `yii_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_auth_assignment`")) {
        $sql = "--
-- Table structure for table `yii_auth_assignment`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `yii_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `yii_auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `yii_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii_auth_assignment`
--

LOCK TABLES `yii_auth_assignment` WRITE;
INSERT INTO `yii_auth_assignment` VALUES ('Admin','1001',NULL,'N;'),('Customer','1003',NULL,'N;'),('Customer','1005',NULL,'N;'),('Customer','1006',NULL,'N;'),('Customer','1007',NULL,'N;'),('Customer','1008',NULL,'N;'),('Customer','1009',NULL,'N;'),('Customer','1010',NULL,'N;'),('Internal','1',NULL,'N;'),('Internal','10',NULL,'N;'),('Internal','1002',NULL,'N;'),('Internal','1011',NULL,'N;'),('Internal','1012',NULL,'N;'),('Internal','1013',NULL,'N;'),('Internal','1014',NULL,'N;'),('Internal','1015',NULL,'N;'),('Internal','1016',NULL,'N;'),('Internal','1017',NULL,'N;'),('Internal','1019',NULL,'N;'),('Internal','1020',NULL,'N;'),('Internal','11',NULL,'N;'),('Internal','12',NULL,'N;'),('Internal','13',NULL,'N;'),('Internal','14',NULL,'N;'),('Internal','15',NULL,'N;'),('Internal','16',NULL,'N;'),('Internal','17',NULL,'N;'),('Internal','18',NULL,'N;'),('Internal','2',NULL,'N;'),('Internal','3',NULL,'N;'),('Internal','4',NULL,'N;'),('Internal','5',NULL,'N;'),('Internal','6',NULL,'N;'),('Internal','7',NULL,'N;'),('Internal','8',NULL,'N;'),('Internal','9',NULL,'N;'),('Supplier','1004',NULL,'N;');

UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_profile`")) {
        $sql = "--
-- Table structure for table `yii_profile`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `yii_profile` (
  `user_id` bigint(20) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `lo1_id` bigint(20) NOT NULL DEFAULT '0',
  `cu1_id` bigint(20) NOT NULL DEFAULT '0',
  `su1_id` bigint(20) NOT NULL DEFAULT '0',
  `user_type` tinyint(4) NOT NULL DEFAULT '0',
  `user_address1` varchar(255) NOT NULL DEFAULT '',
  `user_address2` varchar(255) NOT NULL DEFAULT '',
  `user_city` varchar(50) NOT NULL DEFAULT '',
  `st1_id` bigint(20) NOT NULL DEFAULT '0',
  `user_postal_code` varchar(25) NOT NULL DEFAULT '',
  `user_country` varchar(100) NOT NULL DEFAULT '',
  `work_start` int(11) NOT NULL DEFAULT '0',
  `work_end` int(11) NOT NULL DEFAULT '0',
  `teamwork_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `delete_flag` (`delete_flag`),
  KEY `user_type` (`user_type`),
  KEY `cu1_id` (`cu1_id`),
  KEY `su1_id` (`su1_id`),
  KEY `st1_id` (`st1_id`),
  KEY `lo1_id` (`lo1_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii_profile`
--

LOCK TABLES `yii_profile` WRITE;
/*!40000 ALTER TABLE `yii_profile` DISABLE KEYS */;
INSERT INTO `yii_profile` VALUES (1,0,'Administrator','',0,0,0,1,'','','',0,'','',540,1020,0),(2,0,'Ming','Ma',0,0,0,1,'','','',0,'','',540,1020,143615),(3,0,'Jan','Poehland',0,0,0,1,'','','',0,'','',540,1020,142893),(4,0,'Jongbeom','Ryu',0,0,0,1,'','','',0,'','',540,1020,142889),(5,0,'Nick','Karnick',0,0,0,1,'','','',0,'','',540,1020,172426),(6,0,'Bob','Belbeck',0,0,0,1,'','','',0,'','',540,1020,0),(7,0,'Matt','Van Zant',0,0,0,1,'','','',0,'','',540,1020,143614),(8,0,'Mitsuru','Shiratori',0,0,0,1,'','','',0,'','',540,1020,0),(9,0,'Sharyn','Rose',0,0,0,1,'','','',0,'','',540,1020,0),(10,0,'Jongbeom','Ryu',0,0,0,1,'','','',0,'','',540,1020,0),(11,0,'Peter','Crowley',0,0,0,1,'','','',0,'','',540,1020,187380),(12,0,'Alexander','Kuhnke',0,0,0,1,'','','',0,'','',540,1020,0),(13,0,'Joseph','Strubhart',0,0,0,1,'','','',0,'','',540,1020,0),(14,0,'Jeff','Lundquist',0,0,0,1,'','','',0,'','',540,1020,0),(15,0,'Jordan','Webster',0,0,0,1,'','','',0,'','',540,1020,143613),(16,0,'Piper','Kosel',0,0,0,1,'','','',0,'','',900,500,143617),(17,0,'Scott','Jennerjohn',0,0,0,1,'','','',0,'','',540,1020,143619),(18,0,'David','Niaz',0,0,0,1,'','','',0,'','',540,1020,142894),(1001,0,'System','Administrator',0,0,0,1,'5353 Gamble Drive','Suite 100','St. Louis Park',36,'55416','USA',540,1020,0),(1003,0,'customer','01',0,1,0,2,'','','',0,'','',540,1020,0),(1004,1,'supplier','01',0,0,1,3,'','','',10,'','',540,1020,0),(1005,0,'customer','02',0,2,0,2,'','','',0,'','',540,1020,0),(1006,0,'customer','03',0,3,0,2,'','','',36,'','',540,1020,0),(1007,0,'customer','04',0,4,0,2,'','','',0,'','',540,1020,0),(1008,1,'customer','011',0,1,0,2,'','','',0,'','',540,1020,0),(1009,0,'customer','05',0,5,0,2,'','','',0,'','',540,1020,0),(1010,0,'customer','06',0,6,0,2,'','','',0,'','',540,1020,0),(1011,0,'Internal','01',5,0,0,1,'','','',0,'','',540,1020,0),(1012,0,'Internal','02',6,0,0,1,'','','',0,'','',540,1020,0),(1014,0,'Chad','Tvedt',0,0,0,1,'','','',0,'','',0,0,143612),(1015,0,'Unknown','Unknown',6,0,0,1,'','','',0,'','',0,0,0),(1016,0,'Chad','Burnett',0,0,0,1,'','','',0,'','',0,0,162653),(1017,0,'Grant','Koehler',0,0,0,1,'','','',0,'','',0,0,197995),(1018,1,'Alex','Lappen',0,0,0,1,'','','',0,'','',0,0,203179),(1019,0,'Alex','Lappen',0,0,0,1,'','','',0,'','',0,0,203179),(1020,0,'Ellen ','Burmester',0,0,0,1,'','','',0,'','',0,0,0),(1314,0,'External','01',11,0,0,1,'','','',0,'','',540,1020,0);
/*!40000 ALTER TABLE `yii_profile` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_profile_field`")) {
        $sql = "--
-- Table structure for table `yii_profile_field`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS  `yii_profile_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` text,
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_rights`")) {
        $sql = "/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `yii_rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`),
  CONSTRAINT `yii_rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `yii_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii_rights`
--

LOCK TABLES `yii_rights` WRITE;
/*!40000 ALTER TABLE `yii_rights` DISABLE KEYS */;
/*!40000 ALTER TABLE `yii_rights` ENABLE KEYS */;
UNLOCK TABLES;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_session`")) {
        $sql = "--
-- Table structure for table `yii_session`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `yii_session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`),
  KEY `expire` (`expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_table_log`")) {
        $sql = "--
-- Table structure for table `yii_table_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `yii_table_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log_action` tinyint(4) DEFAULT NULL,
  `model` varchar(45) DEFAULT NULL,
  `model_id` varchar(45) DEFAULT NULL,
  `description` text,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `model` (`model`),
  KEY `model_id` (`model_id`),
  KEY `model_and_model_id` (`model`,`model_id`),
  KEY `log_action` (`log_action`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=42671 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_user`")) {
        $sql = "--
-- Table structure for table `yii_user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `yii_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `superuser` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  `us1_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=1021 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii_user`
--

LOCK TABLES `yii_user` WRITE;
/*!40000 ALTER TABLE `yii_user` DISABLE KEYS */;
INSERT INTO `yii_user` VALUES (1001,'sysadmin','b1912c95ace8a669ab2d42bb656d80e5','david.niaz@comparatio.com','8d4b44f57b7d33fa1936589e2f8b3b1c','2013-08-06 00:15:24','2016-07-01 21:36:11',1,1,0,0,0);
INSERT INTO `yii_user` VALUES (1002,'admin','b1912c95ace8a669ab2d42bb656d80e5','david.niaz@comparatio.com','8d4b44f57b7d33fa1936589e2f8b3b1c','2013-08-06 00:15:24','2016-07-01 21:36:11',1,1,0,0,0);
/*!40000 ALTER TABLE `yii_user` ENABLE KEYS */;
UNLOCK TABLES;
";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }

    if (!$conn->query("DESCRIBE `yii_user_log`")) {
        $sql = "--
-- Table structure for table `yii_user_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `yii_user_log` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `ip_address` varchar(32) NOT NULL DEFAULT '',
  `user_agent` varchar(255) DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout_time` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `update_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`session_id`,`ip_address`,`login_time`),
  KEY `user_id` (`user_id`),
  KEY `session_id` (`session_id`),
  KEY `user_id_session_id` (`user_id`,`session_id`),
  KEY `login_time` (`login_time`),
  KEY `logout_time` (`logout_time`),
  KEY `created_by` (`created_by`),
  KEY `created_on` (`created_on`),
  KEY `modified_by` (`modified_by`),
  KEY `modified_on` (`modified_on`),
  KEY `delete_flag` (`delete_flag`),
  KEY `update_flag` (`update_flag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        file_put_contents('sqlCommand', $sql);
        $sqlLists = SqlParser::parse(file_get_contents("sqlCommand"));
        foreach ($sqlLists as $sql):
            if ($sql != "") {
                $conn->query($sql);
            }
        endforeach;
    }
}

Yii::createWebApplication($config)->run();







