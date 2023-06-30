create table Images
(
    file_id   int auto_increment
        primary key,
    vendor_id  int                                                                                    null,
    product_id int                                                                                    null,
    file_blob blob                                                                                   null,
    file_link varchar(255) default 'https://www.infyenterprise.com/hosting-services/placeholder.jpg' null,
    active     tinyint(1)   default 1                                                                 not null,
    file_size int                                                                                    null,
    file_type varchar(15)                                                                            null,
    constraint files_products_product_id_fk
        foreign key (product_id) references products (product_id),
    constraint files_vendors_vendor_id_fk
        foreign key (vendor_id) references vendors (vendor_id)
);

INSERT INTO Images (file_id, vendor_id, product_id, file_blob, file_link, active, file_size, file_type) VALUES (1, 1, 1, 0x, 'https://www.infyenterprise.com/hosting-services/placeholder.jpg', 0, 1234, '.jpeg');
INSERT INTO Images (file_id, vendor_id, product_id, file_blob, file_link, active, file_size, file_type) VALUES (2, 1, 1, null, 'https://www.infyenterprise.com/hosting-services/placeholder.jpg', 1, 1234, '.jpeg');
INSERT INTO Images (file_id, vendor_id, product_id, file_blob, file_link, active, file_size, file_type) VALUES (3, 1, 1, null, 'https://www.infyenterprise.com/hosting-services/placeholder.jpg', 1, 1234, '.jpeg');
