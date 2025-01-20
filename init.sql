CREATE TABLE users(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  userName TEXT NOT NULL,
  password  TEXT NOT NULL
);

CREATE TABLE cartaporte(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  operador TEXT NOT NULL,
  placa TEXT NOT NULL,
  modelo TEXT NOT NULL,
  ciudad_origen TEXT NOT NULL,
  fecha_salida DATE NOT NULL,
  hora_salida TEXT NOT NULL,
  destino TEXT NOT NULL,
  num_contacto TEXT NOT NULL
);

