<?php
include_once(APPLICATION_PATH . "/inc/db_connect.php");

$tbl_customer = "
CREATE TABLE IF NOT EXISTS tbl_customer (
	id            INT(10)      NOT NULL AUTO_INCREMENT,
	email         VARCHAR(100) NOT NULL,
	password      VARCHAR(50)  NOT NULL,
	first_name    VARCHAR(50)  NOT NULL,
	last_name     VARCHAR(50)  NOT NULL,
	gender        BOOLEAN      NOT NULL DEFAULT '0',
	address_1     VARCHAR(50)  NOT NULL,
	address_2     VARCHAR(50)  NOT NULL,
	town          VARCHAR(50)  NOT NULL,
	county        VARCHAR(50)  NOT NULL,
	postal_code   VARCHAR(10)  NOT NULL,
	country       VARCHAR(25)  NOT NULL,
	mobile        VARCHAR(15)  NOT NULL,
	ipv4          VARCHAR(15)  NOT NULL,
	not_txt_msg   BOOLEAN      NOT NULL DEFAULT '0',
	not_emails    BOOLEAN      NOT NULL DEFAULT '0',
	create_at     DATETIME     NOT NULL,
	last_login	  DATETIME	   NOT NULL,
	activated     BOOLEAN      NOT NULL DEFAULT '0',
	activation_on DATETIME     NOT NULL,
	active        BOOLEAN      NOT NULL DEFAULT '0',
	PRIMARY KEY      (id),
	UNIQUE KEY email (email)
)";
$query = mysqli_query($db_connect, $tbl_customer);
if ($query === TRUE) {
	echo "<h3>tbl_customer table created OK :)</h3>";
} else {
	echo "<h3>tbl_customer table NOT created :(</h3>";
}

$tbl_business = "
CREATE TABLE IF NOT EXISTS tbl_business (
	id			  INT(10)      NOT NULL AUTO_INCREMENT,
	username      VARCHAR(6)   NOT NULL,
	password      VARCHAR(50)  NOT NULL,
	email		  VARCHAR(100) NOT NULL,
	trade_name    VARCHAR(30)  NOT NULL,
	registr_num   VARCHAR(15)  NOT NULL,
	legal_name    VARCHAR(50)  NOT NULL,
	address_1     VARCHAR(50)  NOT NULL,
	address_2     VARCHAR(50)  NOT NULL,
	town          VARCHAR(50)  NOT NULL,
	county        VARCHAR(50)  NOT NULL,
	postal_code   VARCHAR(10)  NOT NULL,
	country       VARCHAR(25)  NOT NULL,
	contact       VARCHAR(50)  NOT NULL,
	phone         VARCHAR(15)  NOT NULL,
	ipv4          VARCHAR(15)  NOT NULL,
	own_card      BOOLEAN      NOT NULL DEFAULT '0',
	create_at     DATETIME     NOT NULL,
	last_login	  DATETIME	   NOT NULL,
	activated     BOOLEAN      NOT NULL DEFAULT '0',
	activation_on DATETIME     NOT NULL,
	active        BOOLEAN      NOT NULL DEFAULT '0',
	PRIMARY KEY      	(id),
	UNIQUE KEY username	(username),
	UNIQUE KEY email    (email)
)";
$query = mysqli_query($db_connect, $tbl_business);
if ($query === TRUE) {
	echo "<h3>tbl_business table created OK :)</h3>";
} else {
	echo "<h3>tbl_business table NOT created :(</h3>";
}

$tbl_user = "
CREATE TABLE IF NOT EXISTS tbl_user (
	id			  INT(10)      NOT NULL AUTO_INCREMENT,
	username      VARCHAR(6)   NOT NULL,
	name          VARCHAR(50)  NOT NULL,
	password      VARCHAR(50)  NOT NULL,
	email		  VARCHAR(100) NOT NULL,
	admin         BOOLEAN      NOT NULL DEFAULT '0',
	business_id   INT(10)      NOT NULL,
	PRIMARY KEY      	(id),
	UNIQUE KEY business	(business_id, username),
	FOREIGN KEY (business_id) REFERENCES tbl_business(id)
)";
$query = mysqli_query($db_connect, $tbl_user);
if ($query === TRUE) {
	echo "<h3>tbl_user table created OK :)</h3>";
} else {
	echo "<h3>tbl_user table NOT created :(</h3>";
}

$tbl_bus_cus = "
CREATE TABLE IF NOT EXISTS tbl_bus_cus (
	customer_id   INT(10)      NOT NULL,
	business_id   INT(10)      NOT NULL,
	card_id       INT(10)      NOT NULL,
	VIP           BOOLEAN      NOT NULL DEFAULT '0',
	vip_reward    VARCHAR(15)  NOT NULL,
	activation_on DATETIME     NOT NULL,
	active        BOOLEAN      NOT NULL DEFAULT '0',
	PRIMARY KEY   (business_id, customer_id),
	UNIQUE KEY    card (business_id, card_id),
	FOREIGN KEY (customer_id) REFERENCES tbl_customer(id),
	FOREIGN KEY (business_id) REFERENCES tbl_business(id)
)";
$query = mysqli_query($db_connect, $tbl_bus_cus);
if ($query === TRUE) {
	echo "<h3>tbl_bus_cus table created OK :)</h3>";
} else {
	echo "<h3>tbl_bus_cus table NOT created :(</h3>";
}

$tbl_unit = "
CREATE TABLE IF NOT EXISTS tbl_unit(
	id			  INT(10)      NOT NULL AUTO_INCREMENT,
	sing_descr    VARCHAR(15)  NOT NULL,
	plur_descr    VARCHAR(15)  NOT NULL,
	PRIMARY KEY (id)
)";
$query = mysqli_query($db_connect, $tbl_unit);
if ($query === TRUE) {
	echo "<h3>tbl_unit table created OK :)</h3>";
} else {
	echo "<h3>tbl_unit table NOT created :(</h3>";
}

$tbl_bus_item = "
CREATE TABLE IF NOT EXISTS tbl_bus_item (
	business_id   INT(10)      NOT NULL,
	id			  VARCHAR(6)   NOT NULL,
    description   VARCHAR(25)  NOT NULL,
	unit_id       INT(3)       NOT NULL,
	convert_rate  DECIMAL(3,2) NOT NULL,
	bonus_rate    INT(3)       NOT NULL,
	vip_reward    DECIMAL(3,2) NOT NULL,
	PRIMARY KEY (business_id, id),
	FOREIGN KEY (business_id) REFERENCES tbl_business(id),
	FOREIGN KEY (unit_id)     REFERENCES tbl_unit(id)
)";
$query = mysqli_query($db_connect, $tbl_bus_item);
if ($query === TRUE) {
	echo "<h3>tbl_bus_item table created OK :)</h3>";
} else {
	echo "<h3>tbl_bus_item table NOT created :(</h3>";
}

$tbl_cus_item = "
CREATE TABLE IF NOT EXISTS tbl_cus_item (
	customer_id   INT(10)      NOT NULL,
	business_id   INT(10)      NOT NULL,
	card_id       INT(10)      NOT NULL,
	item_id       VARCHAR(6)   NOT NULL,
	balance       DECIMAL(3,2) NOT NULL,
	reward        DECIMAL(3,2) NOT NULL,
	PRIMARY KEY (business_id, customer_id, card_id, item_id),
	FOREIGN KEY (business_id)          REFERENCES tbl_business(id),
	FOREIGN KEY (customer_id)          REFERENCES tbl_customer(id),
	FOREIGN KEY (business_id, item_id) REFERENCES tbl_bus_item(business_id, id)
)";
$query = mysqli_query($db_connect, $tbl_cus_item);
if ($query === TRUE) {
	echo "<h3>tbl_cus_item table created OK :)</h3>";
} else {
	echo "<h3>tbl_cus_item table NOT created :(</h3>";
}

$tbl_transaction = "
CREATE TABLE IF NOT EXISTS tbl_transaction (
	id			  BIGINT(19)   NOT NULL AUTO_INCREMENT,
	user_id	      INT(10)      NOT NULL,
	customer_id   INT(10)      NOT NULL,
	business_id   INT(10)      NOT NULL,
	card_id       INT(10)      NOT NULL,
	processed_at  DATETIME     NOT NULL,          
	PRIMARY KEY(id),
	UNIQUE KEY trans (business_id, customer_id, card_id, id),
	FOREIGN KEY (business_id) REFERENCES tbl_business(id),
	FOREIGN KEY (customer_id) REFERENCES tbl_customer(id),
	FOREIGN KEY (user_id)     REFERENCES tbl_user(id)
)";
$query = mysqli_query($db_connect, $tbl_transaction);
if ($query === TRUE) {
	echo "<h3>tbl_transaction table created OK :)</h3>";
} else {
	echo "<h3>tbl_transaction table NOT created :(</h3>";
}

$tbl_trans_item = "
CREATE TABLE IF NOT EXISTS tbl_trans_item (
	trans_id      BIGINT(19)   NOT NULL,
	business_id   INT(10)      NOT NULL,
	item_id       VARCHAR(6)   NOT NULL,
	qty_item      INT(3)       NOT NULL,
	qty_reward    INT(3)       NOT NULL,
	PRIMARY KEY (trans_id, item_id),
	FOREIGN KEY (business_id, item_id) REFERENCES tbl_bus_item(business_id, id),
	FOREIGN KEY (trans_id) REFERENCES tbl_transaction(id)
)";
$query = mysqli_query($db_connect, $tbl_trans_item);
if ($query === TRUE) {
	echo "<h3>tbl_trans_item table created OK :)</h3>";
} else {
	echo "<h3>tbl_trans_item table NOT created :(</h3>";
}

$tbl_bus_email = "
CREATE TABLE IF NOT EXISTS tbl_bus_email (
	id            INT(10)      NOT NULL AUTO_INCREMENT,
	business_id   INT(10)      NOT NULL,
	qtd_sent      INT(6)       NOT NULL,
	sent_at       DATETIME     NOT NULL,
	ipv4          VARCHAR(15)  NOT NULL,
	image		  VARCHAR(255) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (business_id) REFERENCES tbl_business(id)
)";
$query = mysqli_query($db_connect, $tbl_bus_email);
if ($query === TRUE) {
	echo "<h3>tbl_bus_email table created OK :)</h3>";
} else {
	echo "<h3>tbl_bus_email table NOT created :(</h3>";
}

$tbl_bus_txt = "
CREATE TABLE IF NOT EXISTS tbl_bus_txt (
	id            INT(10)      NOT NULL AUTO_INCREMENT,
	business_id   INT(10)      NOT NULL,
	qtd_sent      INT(6)       NOT NULL,
	sent_at       DATETIME     NOT NULL,
	ipv4          VARCHAR(15)  NOT NULL,
	message		  TEXT(300)    NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (business_id) REFERENCES tbl_business(id)
)";
$query = mysqli_query($db_connect, $tbl_bus_txt);
if ($query === TRUE) {
	echo "<h3>tbl_bus_txt table created OK :)</h3>";
} else {
	echo "<h3>tbl_bus_txt table NOT created :(</h3>";
}
?>