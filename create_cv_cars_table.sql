CREATE TABLE IF NOT EXISTS cv_cars_table (car_id INT AUTO_INCREMENT PRIMARY KEY,
       	     	      make VARCHAR(40) NOT NULL,
					  model VARCHAR(40) NOT NULL,
					  year_manufactured INT NOT NULL,
					  milage INT NOT NULL,
					  fair_value INT NOT NULL,
					  base_price INT NOT NULL,
					  registration_date VARCHAR(256) NOT NULL);
