-- create_lokasis_table

CREATE TABLE IF NOT EXISTS `lokasi` (
    id_lokasi         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_lokasi       VARCHAR(255) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;