CREATE DATABASE IF NOT EXISTS laundry CHARACTER SET utf8mb4;
USE laundry;

CREATE TABLE layanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  jenis VARCHAR(20) NOT NULL UNIQUE,
  nama VARCHAR(50) NOT NULL,
  harga INT NOT NULL,
  satuan VARCHAR(10) NOT NULL,
  estimasi VARCHAR(30) NOT NULL
);

CREATE TABLE pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telepon VARCHAR(20) NOT NULL,
  layanan_id INT NOT NULL,
  jumlah DECIMAL(6,1) NOT NULL DEFAULT 1,
  alamat TEXT,
  status ENUM('Baru','Diproses','Selesai','Diambil') NOT NULL DEFAULT 'Baru',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (layanan_id) REFERENCES layanan(id)
);

INSERT INTO layanan (jenis, nama, harga, satuan, estimasi) VALUES
('satuan','Laundry Satuan',7000,'pcs','1-2 hari'),
('kiloan','Laundry Kiloan',13000,'kg','2-4 hari'),
('express','Laundry Express',17000,'kg','1 hari');
