
DROP TABLE IF EXISTS log;
DROP TABLE IF EXISTS tx_normal;
DROP TABLE IF EXISTS tx_internal;
DROP TABLE IF EXISTS wallet_token;
DROP TABLE IF EXISTS user_wallet;
DROP TABLE IF EXISTS probed_wallet;
DROP TABLE IF EXISTS token;
DROP TABLE IF EXISTS users;

                
create table users(	id int primary key auto_increment, 

					first_name varchar(50), 
                    last_name varchar(50), 
                    
                    telegram_username varchar(50), 
                    telegram_id varchar(200),
                    
                    status boolean,
                    
                    is_probed boolean,
                                        
                    created datetime,
                    updated datetime);
                    


create table token(	id int primary key auto_increment,
					
                    contract varchar(100) not null,

                    name varchar(100) not null,
                    short_name varchar(100) not null,
                    

                    current_price decimal(34,18),
                    first_price decimal(34,18),
                    last_price decimal(34,18),
                    last_price_update datetime,
                    growth_since_cad decimal(10, 3),
                    
                    created datetime,
                    updated datetime);
                    
                    
create table user_wallet( 	id int primary key auto_increment,

							user int not null,
							address varchar(100) not null,
                            
							created datetime,
                            updated datetime,
                                                        
                            foreign key (user) references users(id));
                            
                            
create table wallet_token( 	id int primary key auto_increment,
							
							address int not null,
                            contract int not null,
                            
                            quantity decimal(34,18),
                            
                            average_price decimal(34,18),
                            
                            quantity_in decimal(34,18),
                            quantity_out decimal(34,18),
                            
							created datetime,
                            updated datetime,
							
                            foreign key (address) references user_wallet(id),
                            foreign key (contract) references token(id));

create table tx_normal (	id int primary key auto_increment,
							
                            transaction_hash varchar(100) not null,

                            timestamp bigint null,
                            
                            _from int not null,
                            -- _to int not null,
                            _to varchar(100) not null,
							
                            price  decimal(34,18),
                            
                            quantity decimal(34,18),
                            
                            date datetime,
							
                            foreign key (_from) references user_wallet(id)
                            );
                            
create table tx_internal (	id int primary key auto_increment,
							
                            transaction_hash varchar(100) not null,

                            timestamp bigint null,
                            
                            -- _from int not null,
                            _from varchar(100) not null,
                            _to int not null,
                            
							
                            price  decimal(34,18),
                            
                            quantity decimal(34,18),
                            
                            date datetime,

                            foreign key (_to) references user_wallet(id)
                            );

create table log (	id int primary key auto_increment,
					message text,
                    user int not null,
                    created datetime,
                    foreign key (user) references users(id));



/*
'1', '0x905ad6d19e4249e771d9df7668ffc71cb1ad4a31', null, '1', '1', '2021-06-19 06:21:06', '2021-06-19 06:21:06'
*/
create table probed_wallet (	id int primary key auto_increment,
								
                                address varchar(100) not null,
                                
                                user int null,
                                
                                status boolean,
                                
                                is_gemfinder boolean,
                                
                                created datetime,
                                updated datetime
                                );
							

delimiter $$
CREATE TRIGGER Tgr_ProbedWallet_Insert 
BEFORE INSERT ON probed_wallet FOR EACH ROW
BEGIN

	/**
    * Declare the variable to get the next id.
    */
    DECLARE next_probed_wallet_id INTEGER;
    
	/**
    * Declare the user_id variable to store the user_id.
    */
    DECLARE user_id INTEGER;
    
    
    /**
    * Set the id FROM auto_increment.
    */
    SET @next_probed_wallet_id := (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "gff" AND TABLE_NAME = "probed_wallet");
    
    /**
    * Insert the user on table to store wallet and tx.
    */
	INSERT INTO users (first_name, last_name, status, is_probed, created, updated)
    VALUES ('Probed Wallet', @next_probed_wallet_id, TRUE, TRUE, now(), now());
    
    /**
    * Get the user_id value.
    */
    SET @user_id := LAST_INSERT_ID();
    
    /**
    * Insert a wallet to the user.
    */
    INSERT INTO user_wallet (user, address, created, updated)
    VALUES (@user_id, NEW.address, now(), now());
    
    /**
    * Set the 'NEW' user value to find again from the probed wallet.
    */
    SET NEW.user = @user_id;
    
END$$

delimiter $$


 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0x905ad6d19e4249e771d9df7668ffc71cb1ad4a31', '1', '1', now(), now());
 INSERT INTO `tx_normal` (`transaction_hash`, `_from`, `_to`, `price`, `quantity`, `date`) VALUES ('0x626f65cd420760299741102990e5f48dafe675843ef9886874402656aeaa1a94', 1, '0x579f11c75eb4e47f5290122e87ca411644adcd97', '2030.03', '250000000000', '2021-06-19 06:27:21');
 INSERT INTO `tx_internal` (`transaction_hash`, `_from`, `_to`, `price`, `quantity`, `date`) VALUES ('0xe263ef9507ac85d41f9334c8e0a38a691d2afe7625a2ab92818f46a4420f1c16', '0x579f11c75eb4e47f5290122e87ca411644adcd97', 1, '1250.03', '250000000000', '2021-06-19 06:27:21');