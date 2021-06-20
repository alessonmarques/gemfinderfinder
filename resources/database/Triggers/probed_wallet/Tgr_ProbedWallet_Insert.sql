delimiter $$
CREATE TRIGGER Tgr_ProbedWallet_Insert 
BEFORE INSERT ON probed_wallet FOR EACH ROW
BEGIN
	/**
    * Declare the user_id variable to store the user_id.
    */
    DECLARE user_id INTEGER;
	
    /**
    * Insert the user on table to store wallet and tx.
    */
	INSERT INTO users (first_name, last_name, status, is_probed, created, updated)
    VALUES ('Probed Wallet', NEW.id, TRUE, TRUE, now(), now());
    
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