USE gff;

/*
	DROP TABLE IF EXISTS log;
	DROP TABLE IF EXISTS tx_normal;
	DROP TABLE IF EXISTS tx_internal;
	DROP TABLE IF EXISTS wallet_token;
	DROP TABLE IF EXISTS user_wallet;
	DROP TABLE IF EXISTS probed_wallet;
	DROP TABLE IF EXISTS token;
	DROP TABLE IF EXISTS users;
*/
                


create table users(	id int primary key auto_increment, 

					first_name varchar(50), 
                    last_name varchar(50), 
                    
                    telegram_username varchar(50), 
                    telegram_id varchar(200),
                    
                    status boolean,
                                        
                    created datetime,
                    updated datetime);
                    


create table token(	id int primary key auto_increment,
					
                    name varchar(100) not null,
                    short_name varchar(100) not null,
                    
                    contract varchar(100) not null,
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
                            
                            _from int not null,
                            _to int not null,
							
                            price  decimal(34,18),
                            
                            quantity decimal(34,18),
                            
                            date datetime,
							
                            foreign key (_from) references user_wallet(id),
                            foreign key (_to) references token(id));
                            
create table tx_internal (	id int primary key auto_increment,
							
                            transaction_hash varchar(100) not null,
                            
                            _from int not null,
                            _to int not null,
							
                            price  decimal(34,18),
                            
                            quantity decimal(34,18),
                            
                            date datetime,

                            foreign key (_from) references token(id),
                            foreign key (_to) references user_wallet(id));

create table log (	id int primary key auto_increment,
					message text,
                    user int not null,
                    created datetime,
                    foreign key (user) references users(id));



                
create table probed_wallet (	id int primary key auto_increment,
								
                                address varchar(100) not null,
                                
                                status boolean,
                                
                                is_gemfinder boolean,
                                
                                created datetime,
                                updated datetime
                                );
							
#-------------------------------------

INSERT INTO `gff`.`probed_wallet` (`address`, `status`, `is_gemfinder`, `created`, `updated`) VALUES ('0x905ad6d19e4249e771d9df7668ffc71cb1ad4a31', '1', '1', now(), now());