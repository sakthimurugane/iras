create table suppliers(
    supplier_id int not null AUTO_INCREMENT,
    supplier_phone varchar(255),
    supplier_name varchar(255),
    supplier_address varchar(255),
    contact_person varchar(255),
    item_desc varchar(255),
    is_deleted int not null,
    created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (supplier_id)
    )
    
create table customer(
    customer_id int not null AUTO_INCREMENT,
    customer_name varchar(255),
    customer_phone varchar(255),
    customer_address varchar(255),
    remarks varchar(255),
    is_deleted int not null,
    created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (customer_id)
    )

create table products(
    product_id int not null AUTO_INCREMENT,
    product_code varchar(255),
    product_name varchar(255),
    hsnsac varchar(255),
    o_price varchar(255),
    s_price varchar(255),
    profit varchar(255),
    quantity int not null,
    is_deleted int not null,
    arrival_date datetime,
    expiry_date datetime,
    created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (product_id)
    )

create table sales_order(
    sale_id int not null AUTO_INCREMENT,
    ordernum varchar(255),
    product_id int not null,
    item_name varchar(255),
    item_code varchar(255),
    item_hsn varchar(255),
    bill_price int not null,
    bill_qty int not null,
    is_deleted int not null,
    bill_amount int not null
    created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (sale_id),
    )
    
 create table tax_slab(
 slab_id int not null AUTO_INCREMENT,
 slab_name varchar(255),
 slab_desc varchar(255),
 tax_type varchar(255),
 tax_value int not null,
 status varchar(255),
     is_deleted int not null,
    created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (slab_id),
 )
 
  create table home(
 	home_id int not null AUTO_INCREMENT,
 	home_name varchar(255),
 	home_legal_name varchar(255),
 	home_gstin varchar(255),
 	home_propertier varchar(255),
 	home_mobile varchar(255),
 	home_landline varchar(255),
 	is_tax int not null,
    is_deleted int not null,
    created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (home_id),
 )
 
 
   create table invoice_details(
 	invoice_id int not null AUTO_INCREMENT,
 	ordernum varchar(255),
 	customer_id varchar(255),
 	payment_type varchar(255),
 	payment_status varchar(255),
 	due_date varchar(255),
 	billed_amount int not null,
 	cash_paid int not null,
    advance_amount int not null,
    is_deleted int not null,
    created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (invoice_id)
 )
 
    create table sales_tax(
 	sales_tax_id int not null AUTO_INCREMENT,
 	ordernum varchar(255),
	slab_id int ,
	tax_amount int,
	is_deleted int not null,
	created_on datetime,
    created_by varchar(255),
    modified_on datetime,
    modified_by varchar(255),
    primary key (sales_tax_id)
 )
 
 
 
 
