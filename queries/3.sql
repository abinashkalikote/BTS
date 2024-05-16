USE bank;
DELETE FROM fin_transactions;
ALTER TABLE fin_transactions AUTO_INCREMENT = 1;

USE bank;
DELETE FROM interest_calculation;
ALTER TABLE interest_calculation AUTO_INCREMENT = 1;

USE bank;
DELETE FROM fin_accounts;
ALTER TABLE fin_accounts AUTO_INCREMENT = 1;