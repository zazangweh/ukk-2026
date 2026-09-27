-- create_kondisis_table

CREATE TABLE IF NOT EXISTS `kondisi` (
    id_kondisi         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kondisi       VARCHAR(255) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;