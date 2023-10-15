# hotel-booking-backend

CREATE TABLE rooms (
	id int AUTO_INCREMENT PRIMARY KEY,
  room_type VARCHAR(255) NOT NULL,
  price VARCHAR(255) NOT NULL,
  room_size VARCHAR(255) NOT NULL,
  accessories VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  available BOOLEAN DEFAULT true,
  time_to_available DATETIME
);
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    room_type VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    applied_date DATETIME NOT NULL
);
CREATE TABLE customer_per_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    room_id INT NOT NULL,
    duration INT NOT NULL,
    applied_date DATETIME NOT NULL
);
