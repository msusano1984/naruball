function Usuario(nombre, appaterno, apmaterno, password, verificapassword, dd, mm, yyyy, placa, categorias, email){
	this.nombre = nombre;
	this.appaterno = appaterno;
	this.apmaterno = apmaterno;
	this.password = password;
	this.verificapassword = verificapassword;
	this.dd = dd;
	this.mm = mm;
	this.yyyy = yyyy;
	this.placa = placa;
	this.categorias = categorias;
	this.fecha_nacimiento = new Date();
	this.email = email;
	/*
	for(var i in categorias){
		var foo = new UsuarioCategorias();
		foo.idUsuario = 0;
		foo.idCategoria = categorias[i].idCategoria;
		this.categorias.push(foo);
	}
	*/

}
function UsuarioCategorias(idUsuario, idCategoria){
	this.idUsuario = idUsuario;
	this.idCategoria = idCategoria;

}
function Login(email, password){
	this.email = email;
	this.password = password;
}

function Empresa(id,nombre,estatus){
	this.estatus = estatus;
	this.id = id;
	this.nombre= nombre;
}
function Subastas(idSubasta, nombreSubasta, IdTipoSubasta, fechaInicio, fechaFin, empresas, visible){
	this.idSubasta = idSubasta;
	this.nombreSubasta = nombreSubasta;
	this.IdTipoSubasta = IdTipoSubasta;
	this.fechaInicio = fechaInicio;
	this.fechaFin = fechaFin;
	this.empresas = empresas;
	this.visible = 1;
}	

function Cotizacion(idUsuario,nombre,correo,telefono,marca,modelo,tipo,estatus,subServicios){

	this.idUsuario = idUsuario;
	this.nombre = nombre;
	this.correo = correo;
	this.telefono = telefono;
	this.marca = marca;
	this.modelo = modelo;
	this.tipo = tipo;
	this.estatus = estatus;  
	this.subServicios = subServicios;

}
function CotizacionServicio(idServicio,idSubServicios){

	this.idSubServicios = idSubServicios;
	this.idServicio = idServicio;

}
function SubServicios (idSubServicio,idServicio,nombre,requisitos,estatus){
	this.idSubServicio = idSubServicio;
	this.idServicio = idServicio;
	this.nombre = nombre;
	this.requisitos = requisitos;
	this.estatus = estatus;
}
function Autos(idAuto, enVenta, precio, marca, modelo, color, anio, km, transmision, estado, ciudad, descripcion, estatus, publicado, fechaCreacion, features, fotos, idSubasta){
 	
    this.idAuto = idAuto;
    this.enVenta = enVenta;
    this.precio = precio;
    this.marca = marca;
    this.modelo = modelo;
    this.color = color;
    this.anio = anio;
    this.km = km;
    this.transmision = transmision;
    this.estado = transmision; 
    this.ciudad = ciudad;
    this.descripcion = descripcion;
    this.estatus  = estatus;
    this.publicado = publicado;
    this.fechaCreacion = fechaCreacion;
    this.features = features;
    this.fotos = fotos;
    this.idSubasta = idSubasta;
}
function Marca(id, descripcion, estatus){
	this.id = id;
	this.descripcion = descripcion;
	this.estatus = estatus;
}