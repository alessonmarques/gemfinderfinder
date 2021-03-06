USE gff;



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
							
#-------------------------------------

 

 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0x905ad6d19e4249e771d9df7668ffc71cb1ad4a31', '1', '1', now(), now());
 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0xe05797c279541ff102100445123fcf45958deb68', '1', '1', now(), now());
 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0x662339ddef1b80385cc1e709a4b9772518f65d0d', '1', '1', now(), now());
 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0x5390d4663aa36ca54c07a55065ba54d5fc1a4c25', '1', '1', now(), now());
 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0x816c8d6a41915ac50d78b881c93f40714aeae1de', '1', '1', now(), now());
 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0x3f1a405c7b7ad771414a03393de12454ddb0a765', '1', '1', now(), now());
 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0xca4d99a875f1021b318e7d22f540015923059178', '1', '1', now(), now());
 INSERT INTO `probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0xf8fc63200e181439823251020d691312fdcf5090', '1', '1', now(), now());
 

 INSERT INTO `gff`.`tx_normal` (`transaction_hash`, `_from`, `_to`, `price`, `quantity`, `date`) VALUES ('0x626f65cd420760299741102990e5f48dafe675843ef9886874402656aeaa1a94', 1, '0x579f11c75eb4e47f5290122e87ca411644adcd97', '2030.03', '250000000000', '2021-06-19 06:27:21');