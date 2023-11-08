create TABLE Users (
  user_id INT PRIMARY KEY,
  username VARCHAR(255),
  email VARCHAR(255)
);

create TABLE Vendors (
  vendor_id INT PRIMARY KEY,
  user_id INT,
  vendor_name VARCHAR(255),
  vendor_email VARCHAR(255),
  FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

create TABLE Products (
  product_id INT PRIMARY KEY,
  vendor_id INT,
  product_name VARCHAR(255),
  price DECIMAL(10, 2),
  FOREIGN KEY (vendor_id) REFERENCES Vendors(vendor_id)
);

create TABLE Payments (
  payment_id INT PRIMARY KEY,
  vendor_id INT,
  amount DECIMAL(10, 2),
  payment_date DATE,
  FOREIGN KEY (vendor_id) REFERENCES Vendors(vendor_id)
);

create TABLE Invoices (
  invoiceId INT PRIMARY KEY,
  vendor_id INT,
  invoice_date DATE,
  total_amount DECIMAL(10, 2),
  FOREIGN KEY (vendor_id) REFERENCES Vendors(vendor_id)
);

create TABLE Cart (
  cart_id INT PRIMARY KEY,
  user_id INT,
  product_id INT,
  quantity INT,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

create TABLE QR_code (
  qr_id INT PRIMARY KEY,
  vendor_id INT,
  product_id INT,
  image_blob BLOB,
  image_link VARCHAR(255),
  FOREIGN KEY (vendor_id) REFERENCES Vendors(vendor_id),
  FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

CREATE TABLE Images (
  file_id INT PRIMARY KEY,
  vendor_id INT,
  product_id INT,
  file_blob BLOB,
  file_link VARCHAR(255),
  FOREIGN KEY (vendor_id) REFERENCES Vendors(vendor_id),
  FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

-- Sample data for Users
insert into Users (user_id, username, email)
values
  (1, 'User1', 'user1@example.com'),
  (2, 'User2', 'user2@example.com'),
  (3, 'User3', 'user3@example.com'),
  (4, 'User4', 'user4@example.com'),
  (5, 'User5', 'user5@example.com');

-- Sample data for Vendors
insert into Vendors (vendor_id, user_id, vendor_name, vendor_email)
values
  (1, 1, 'Vendor 1', 'vendor1@example.com'),
  (2, 2, 'Vendor 2', 'vendor2@example.com'),
  (3, 3, 'Vendor 3', 'vendor3@example.com'),
  (4, 4, 'Vendor 4', 'vendor4@example.com'),
  (5, 5, 'Vendor 5', 'vendor5@example.com');

-- Sample data for Products
insert into Products (product_id, vendor_id, product_name, price)
values
  (1, 1, 'Product 1', 9.99),
  (2, 1, 'Product 2', 19.99),
  (3, 2, 'Product 3', 14.99),
  (4, 3, 'Product 4', 24.99),
  (5, 4, 'Product 5', 29.99);

-- Sample data for Payments
insert into Payments (payment_id, vendor_id, amount, payment_date)
values
  (1, 1, 50.00, '2023-06-01'),
  (2, 2, 100.00, '2023-06-02'),
  (3, 3, 75.00, '2023-06-03'),
  (4, 4, 120.00, '2023-06-04'),
  (5, 5, 90.00, '2023-06-05');

-- Sample data for Invoices
insert into Invoices (invoiceId, vendor_id, invoice_date, total_amount)
values
  (1, 1, '2023-06-01', 150.00),
  (2, 2, '2023-06-02', 200.00),
  (3, 3, '2023-06-03', 175.00),
  (4, 4, '2023-06-04', 220.00),
  (5, 5, '2023-06-05', 190.00);

-- Sample data for Cart
insert into Cart (cart_id, user_id, product_id, quantity)
values
  (1, 1, 1, 2),
  (2, 1, 3, 1),
  (3, 2, 2, 3),
  (4, 3, 4, 1),
  (5, 4, 5, 2);

insert into QR_code (qr_id, vendor_id, product_id, image_blob, image_link)
values
    (1, 1, 1, null, 'https://example.com/image1.png'),
    (2, 2, 2, NULL, 'https://example.com/image2.png'),
    (3, 3, 3, NULL, 'https://example.com/image3.png'),
    (4, 4, 4, NULL, 'https://example.com/image4.png'),
    (5, 5, 5, NULL, 'https://example.com/image5.png');


alter table Users
    add active bool default true not null;

alter table QR_code
    add active bool default true not null;

alter table Cart
    add active bool default true not null;

alter table Invoices
    add active bool default true not null;

alter table Payments
    add active bool default true not null;

alter table Products
    add active bool default true not null;

alter table Vendor
    add active bool default true not null;

alter table Images
    add active bool default true not null;