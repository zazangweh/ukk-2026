-- create_siswas_table

CREATE TABLE IF NOT EXISTS `siswa` (
    id_siswa         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user       INT(255) NOT NULL,
    nis      VARCHAR(255) NOT NULL,
    nama_siswa       VARCHAR(255) NOT NULL,
    kelas      VARCHAR(10) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,

    CONSTRAINT fk_siswa_users FOREIGN KEY (id_users)
    REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
