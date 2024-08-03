 create database bd_quiz;
 use bd_quiz;

CREATE TABLE `config` (
  `id` int(11) primary key NOT NULL auto_increment,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `equipos` (
   `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
   `nombre_equipo` VARCHAR(100) NOT NULL,
   `partida` VARCHAR(100),
    puntuacion float,
   `estado` BOOLEAN DEFAULT FALSE,
   INDEX (`nombre_equipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `miembros` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `equipo_id` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `grupo` varchar(20),
  FOREIGN KEY (`equipo_id`) REFERENCES `equipos`(`nombre_equipo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `config` (`usuario`, `password`) VALUES
('oscar', '123');

CREATE TABLE `temas` (
  `id` int(11) primary key auto_increment NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `preguntas` (
  `id` int(11) primary key auto_increment NOT NULL,
  `tema` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `opcion_a` text NOT NULL,
  `opcion_b` text NOT NULL,
  `opcion_c` text NOT NULL,
  `opcion_d` text NOT NULL,
  `correcta` varchar(1) NOT NULL,
   FOREIGN KEY (`tema`) REFERENCES temas(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table partida(
    id int(11) primary key not null auto_increment,
    nombre varchar(100) not null,
    tema int(11) not null,
    fecha date not null,
    estado boolean default false,
	`totalPreguntas` int(11),
   `Tiempo_por_pregunta` int(11),
  FOREIGN KEY (tema) REFERENCES temas(id) on delete cascade,
    INDEX (nombre)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


create table resultados(
     `id` int(11) primary key auto_increment NOT NULL,
     tema VARCHAR(100) NOT NULL,
     equipo VARCHAR(100) NOT NULL,
     partida VARCHAR(100)not null,
     respuestas text not null,
     correcta boolean,
	FOREIGN KEY (equipo) REFERENCES equipos(nombre_equipo),
    FOREIGN KEY (partida) REFERENCES partida(nombre) 
);

INSERT INTO `temas` (`nombre`) VALUES
('Introducción a las TIC'),
('Introducción a Redes'),
('Programación estructurado'),
('Estructura de datos'),
('Programación Orientada a Objetos');

INSERT INTO `preguntas` (`tema`, `pregunta`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `correcta`) VALUES
-- Introducción a las TIC
(1, '¿Qué significa TIC?', 'Tecnología de Internet y Comunicaciones', 'Tecnología de Información y Comunicaciones','Tecnología de Información y Ciencia', 'Tecnología de Industrias Creativas', 'B'),
(1, '¿Qué es una computadora?', 'Un dispositivo que permite realizar llamadas telefónicas', 'Un aparato electrónico que sirve para calcular la hora', 'Un dispositivo electrónico que procesa datos y realiza tareas según un conjunto de instrucciones', 'Un dispositivo utilizado únicamente para juegos electrónicos', 'C'),
(1, '¿Qué es el hardware?', 'Los programas y aplicaciones que corren en una computadora', 'El conjunto de componentes físicos de una computadora', 'Un tipo de software utilizado para juegos', 'Un sistema operativo para computadoras', 'B'),
(1, '¿Qué es el software?',  'El conjunto de programas y aplicaciones que permiten a una computadora realizar tareas', 'El conjunto de componentes físicos de una computadora', 'Un dispositivo de almacenamiento externo', 'Un componente interno de la computadora que regula la temperatura', 'A'),
(1, '¿Qué es un sistema operativo?', 'Un programa de edición de texto', 'Un tipo de hardware que permite conectar la computadora a Internet','Una aplicación para realizar presentaciones', 'Un conjunto de software que gestiona los recursos del hardware y proporciona servicios a los programas', 'D'),
(1, '¿Qué es una red de computadoras?', 'Un conjunto de computadoras conectadas entre sí para compartir recursos y datos.', 'Un programa que se usa para diseñar gráficos.', 'Un tipo de software.', 'Un dispositivo de entrada.', 'A'),
(1, '¿Qué es un navegador web?', 'Un tipo de hardware.', 'Un sistema operativo.','Un programa que permite acceder y visualizar sitios web en Internet.', 'Un dispositivo de almacenamiento.', 'C'),
(1, '¿Qué es la nube (cloud)?', 'Un sistema operativo.', 'Un conjunto de servidores en Internet que almacenan y procesan datos.', 'Un tipo de red local.', 'Un dispositivo de entrada.', 'B'),
(1, '¿Qué es una base de datos?', 'Un programa que gestiona los recursos de la computadora.', 'Un conjunto organizado de datos que puede ser fácilmente accedido, gestionado y actualizado.', 'Un tipo de hardware.', 'Un dispositivo de salida.', 'B'),
(1, '¿Qué es la inteligencia artificial (IA)?', 'Un tipo de software que imita el comportamiento humano.', 'Un dispositivo de entrada.', 'Un sistema operativo.', 'Un conjunto de tecnologías que permiten a las máquinas realizar tareas que requieren inteligencia humana.', 'D'),
-- Introducción a Redes
(2, '¿Qué es una red de computadoras?','Un software que controla las operaciones de una computadora.', 'Conjunto de dispositivos interconectados entre sí para compartir recursos y comunicarse.', 'Una base de datos de información en línea.', 'Un tipo de memoria RAM.',  'B'),
(2, '¿Qué es una dirección IP?', 'Un identificador único que se asigna a cada dispositivo conectado a una red.', 'Un tipo de lenguaje de programación para aplicaciones web.', 'Un formato de archivo utilizado para almacenar imágenes digitales.', 'Una forma de direccionar correos electrónicos.', 'A'), 
(2, '¿Qué es un servidor?', 'Un dispositivo de entrada en una red de computadoras.', 'Un conjunto de cables de red.', 'Un software que gestiona el acceso a recursos compartidos por otros dispositivos en la red.', 'Un sistema operativo para computadoras personales.', 'C'),
(2, '¿Qué es un router?', 'Un tipo de impresora láser.', 'Un dispositivo que conecta múltiples redes y dirige el tráfico entre ellas.', 'Un programa antivirus.', 'Una herramienta de edición de video.', 'B'),
(2, '¿Qué es el protocolo TCP/IP?','Un tipo de cable de red.', 'Un sistema de cifrado para datos sensibles.', 'Un conjunto de reglas para la comunicación de datos en redes de computadoras.','Un dispositivo para almacenamiento en la nube.', 'C'),
(2, '¿Qué es una red de área local (LAN)?', 'Una red que cubre un área geográfica pequeña como una oficina o un edificio.', 'Una red que cubre grandes áreas geográficas como ciudades o países.', 'Un tipo de conexión inalámbrica.', 'Un dispositivo de almacenamiento de datos.', 'A'),
(2, '¿Qué es un switch en una red de computadoras?', 'Un dispositivo que almacena datos.', 'Un dispositivo que conecta y enruta tráfico entre varios dispositivos en una red local.', 'Un tipo de cable de red.', 'Un protocolo de seguridad.', 'B'),
(2, '¿Qué es una red de área amplia (WAN)?', 'Una red que cubre un área geográfica pequeña como una oficina o un edificio.', 'Una red que cubre grandes áreas geográficas como ciudades, países o continentes.', 'Un tipo de conexión inalámbrica.', 'Un dispositivo de almacenamiento de datos.', 'B'),
(2, '¿Qué es un firewall?', 'Un dispositivo o software que controla el acceso y protege una red de amenazas externas.', 'Un programa para compartir archivos.', 'Un tipo de cable de red.', 'Un sistema operativo.', 'A'),
(2, '¿Qué es el modelo OSI?', 'Un tipo de dirección IP.', 'Un estándar para la interconexión de sistemas abiertos que describe las funciones de red en siete capas.', 'Un lenguaje de programación.', 'Un dispositivo de almacenamiento.', 'B'),
-- Programación Estructurada
(3, 'Define qué es un lenguaje de programación estructurado.', 'Un lenguaje que permite descomponer un programa en módulos.', 'Un lenguaje que no utiliza estructuras de control.', 'Un lenguaje que solo se usa para gráficos.', 'Un lenguaje sin funciones.', 'A'),
(3, '¿Cuáles son las principales características de los lenguajes de programación estructurados?', 'Rápido, seguro y eficiente.', 'Gráfico, colorido y detallado.', 'Modularidad, uso de estructuras de control y legibilidad.', 'Largo, complejo y detallado.', 'C'),
(3, 'Explica la importancia de la modularidad en la programación estructurada.', 'Hace el código más rápido.', 'Aumenta el tamaño del programa.','Facilita el mantenimiento y la reutilización del código.', 'Reduce la memoria necesaria.', 'C'),
(3, '¿Qué es el concepto de "caja negra" en la programación estructurada?', 'Tratar una función o módulo sin conocer su implementación interna.', 'Una herramienta de diseño gráfico.', 'Un tipo de hardware.', 'Un lenguaje de programación.', 'A'),
(3, 'Describe las diferencias entre programación estructurada y programación orientada a objetos.', 'La programación estructurada no usa funciones.', 'La programación orientada a objetos no usa objetos.', 'No hay diferencias significativas.', 'La programación estructurada se enfoca en funciones, la orientada a objetos en objetos.', 'D'),
(3, '¿Cómo se implementa la reutilización de código en la programación estructurada?', 'Usando variables globales.', 'Mediante funciones y procedimientos.', 'Evitando el uso de módulos.', 'Escribiendo todo el código desde cero.', 'B'),
(3, '¿Por qué es importante la legibilidad del código en los lenguajes de programación estructurados?', 'Facilita la comprensión y el mantenimiento del código.', 'Hace el código más rápido.', 'Aumenta el tamaño del programa.', 'Reduce la memoria necesaria.', 'A'),
(3, '¿Qué es una estructura de control en programación estructurada?', 'Un tipo de variable global.', 'Un lenguaje de programación.','Un conjunto de instrucciones que controla el flujo de ejecución de un programa.', 'Un sistema operativo.', 'C'),
(3, '¿Cuál es la diferencia principal entre un bucle "for" y un bucle "while"?', 'Un bucle "while" se usa cuando se conoce el número de iteraciones, mientras que un bucle "for" se usa cuando no se conoce.', 'Un bucle "for" se usa cuando se conoce el número de iteraciones, mientras que un bucle "while" se usa cuando no se conoce.', 'No hay diferencias entre ellos.', 'Un bucle "for" es más rápido que un bucle "while".', 'B'),
(3, '¿Qué es una función recursiva en programación estructurada?', 'Una función que se llama a sí misma.', 'Una función que no utiliza estructuras de control.', 'Una función que se usa solo para gráficos.', 'Una función sin parámetros.', 'A'),
-- Estrutura de datos 
(4, 'Define y proporciona un ejemplo de una lista en programación.', 'Una función que realiza operaciones matemáticas.', 'Un tipo de variable que almacena múltiples valores en una sola variable.', 'Una colección ordenada de elementos; ejemplo: lista = [1, 2, 3].', 'Una estructura de control de flujo que ejecuta bloques de código repetidamente.', 'C'),
(4, '¿Cuál es la diferencia entre una lista y un arreglo?', 'Los arreglos permiten operaciones más complejas que las listas.', 'Las listas y los arreglos son completamente intercambiables.', 'Las listas pueden cambiar de tamaño; los arreglos tienen tamaño fijo.', 'Las listas son una característica exclusiva de ciertos lenguajes de programación.', 'C'),
(4, 'Describe qué es una pila (stack) y cómo funciona.', 'Estructura jerárquica; se usa insert y delete.', 'Estructura FIFO (First In, First Out); se usa enqueue y dequeue.', 'Estructura circular; se usa add y remove.', 'Estructura LIFO (Last In, First Out); se usa push y pop.', 'D'),
(4, 'Explica el concepto de cola (queue) y menciona un ejemplo de su uso.', 'Estructura FIFO (First In, First Out); se usa en colas de impresión.', 'Estructura LIFO (Last In, First Out); se usa en funciones recursivas.', 'Estructura circular; se usa en algoritmos de ordenamiento.', 'Estructura jerárquica; se usa en árboles binarios.', 'A'),
(4, '¿Qué es un árbol binario y cuáles son sus aplicaciones?', 'Una estructura lineal con enlaces.', 'Un tipo de arreglo bidimensional.', 'Estructura jerárquica con nodos, usada en búsquedas y jerarquías.', 'Un método de ordenamiento complejo.', 'C'),
(4, 'Describe la diferencia entre una estructura de datos estática y una dinámica.', 'Dinámica tiene tamaño fijo; estática puede cambiar de tamaño.', 'Estática es más eficiente en términos de tiempo que dinámica.', 'Estática se usa solo en lenguajes de bajo nivel, dinámica en lenguajes de alto nivel.', 'Estática tiene tamaño fijo; dinámica puede cambiar de tamaño.', 'D'),
(4, '¿Cómo se implementa una lista enlazada y cuáles son sus ventajas?', 'Usando nodos que apuntan al siguiente; ventajas: inserciones y eliminaciones eficientes.', 'Usando arreglos bidimensionales; ventajas: acceso rápido a elementos.', 'Usando matrices; ventajas: fácil administración de memoria.', 'Usando constantes; ventajas: inmutabilidad de los datos.', 'A'),
(4, 'Explica qué es un grafo y proporciona un ejemplo de su uso en informática.', 'Conjunto de nodos y aristas; usado en redes sociales.', 'Un tipo de estructura lineal usada para almacenar datos.', 'Un algoritmo de ordenamiento complejo.', 'Un lenguaje de programación especializado.', 'A'),
(4, '¿Cuál es la diferencia entre un array unidimensional y un array multidimensional?', 'Unidimensional permite más operaciones que multidimensional.', 'Unidimensional tiene una sola fila; multidimensional tiene múltiples filas y/o columnas.', 'Multidimensional es más eficiente en términos de memoria que unidimensional.', 'Unidimensional solo se usa en lenguajes de bajo nivel, multidimensional en lenguajes de alto nivel.', 'B'),
(4, '¿Qué es una estructura de datos?', 'Un conjunto de algoritmos utilizados para manipular datos.', 'Es una forma de organizar y almacenar datos, esencial para la eficiencia del programa.', 'Una metodología para diseñar la arquitectura del software.', 'Un componente crucial del hardware que mejora el rendimiento del sistema.', 'B'),
-- Programacion Orientada a Objetos

(5, '¿Qué es la programación orientada a objetos (POO)?', 'Una metodología de desarrollo ágil.', 'Un tipo de base de datos relacional.', 'Un paradigma de programación basado en el uso de objetos y clases.', 'Un lenguaje de scripting.', 'C'),
(5, '¿Qué es una clase en POO?', 'Un modelo o plantilla para crear objetos.', 'Una estructura de control.', 'Una base de datos.', 'Un tipo de variable.', 'A'),
(5, '¿Qué es un objeto en POO?', 'Una función global.', 'Una instancia de una clase.', 'Un tipo de archivo.', 'Un tipo de error.', 'B'),
(5, '¿Cuáles son los cuatro pilares de la programación orientada a objetos?', 'Sintaxis, semántica, pragmática y lógica.', 'Variables, constantes, loops y condicionales.', 'Declaración, inicialización, asignación y destrucción.', 'Encapsulamiento, herencia, polimorfismo y abstracción.', 'D'),
(5, '¿Qué es el encapsulamiento en POO?', 'La creación de múltiples formas de una función.', 'La herencia de características de otra clase.', 'La ocultación de los detalles internos de un objeto.', 'La representación abstracta de una entidad.', 'C'),
(5, '¿Qué es la herencia en POO?', 'El mecanismo por el cual una clase puede derivar de otra.', 'La ocultación de datos internos.', 'La capacidad de definir múltiples funciones con el mismo nombre.', 'La creación de una instancia de una clase.', 'A'),
(5, '¿Qué es el polimorfismo en POO?', 'La declaración de una clase abstracta.', 'La creación de una nueva clase a partir de otra.', 'La ocultación de detalles de implementación.', 'La capacidad de una función de tomar múltiples formas.', 'D'),
(5, '¿Qué es la abstracción en POO?', 'La creación de múltiples formas de una función.', 'La representación simplificada de una entidad mediante la ocultación de los detalles complejos.', 'La herencia de características de otra clase.', 'La definición de variables y métodos.', 'B'),
(5, '¿Qué es un método en POO?', 'Una variable global.', 'Una función definida dentro de una clase.', 'Un tipo de objeto.', 'Un archivo ejecutable.', 'B'),
(5, '¿Qué es un constructor en POO?', 'Una función especial que se llama automáticamente al crear un objeto.', 'Un tipo de bucle.', 'Una estructura condicional.', 'Un operador matemático.', 'A');