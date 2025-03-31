CREATE TABLE IF NOT EXISTS cv_users_cars_table (user_id INT NOT NULL,
       	     	    	car_id INT NOT NULL,
						PRIMARY KEY (user_id, car_id),
						FOREIGN KEY (user_id) REFERENCES cv_users_table(user_id) ON DELETE CASCADE,
						FOREIGN KEY (car_id) REFERENCES cv_cars_table(car_id) ON DELETE CASCADE);
