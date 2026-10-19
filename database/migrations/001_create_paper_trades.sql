-- Reference migration; app/Database/Migrator.php applies this idempotently.
CREATE TABLE IF NOT EXISTS paper_trades (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, symbol VARCHAR(32) NOT NULL,
 side ENUM('long','short') NOT NULL, entry_price DECIMAL(28,10) NOT NULL,
 stop_price DECIMAL(28,10) NOT NULL, target_price DECIMAL(28,10) NOT NULL,
 capital DECIMAL(18,2) NOT NULL, risk_percent DECIMAL(6,3) NOT NULL,
 risk_amount DECIMAL(18,4) NOT NULL, notional_estimate DECIMAL(28,8) NOT NULL,
 status ENUM('planned','closed','cancelled') NOT NULL DEFAULT 'planned', note VARCHAR(180) NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX idx_paper_created(created_at), INDEX idx_paper_status(status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
