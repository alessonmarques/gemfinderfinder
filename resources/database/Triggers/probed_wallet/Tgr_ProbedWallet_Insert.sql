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