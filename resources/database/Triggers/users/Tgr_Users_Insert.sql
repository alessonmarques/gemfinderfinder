delimiter $$
CREATE TRIGGER Tgr_Users_Insert 
AFTER INSERT ON users FOR EACH ROW
BEGIN
	/*
	IF NEW.first_name = 'Probed Wallet' THEN
		UPDATE probed_wallet SET user = NEW.id WHERE id = NEW.last_name;
    END IF;
    */
END$$