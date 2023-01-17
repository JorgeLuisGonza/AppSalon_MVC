const cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){tabs(),AntSig(),consultarAPI(),nombreCliente(),idCliente(),seleccionaFecha(),seleccionarHora(),mostrarResumen()}function tabs(){const e=document.querySelector('[data-paso="1"]'),t=document.querySelector('[data-paso="2"]'),a=document.querySelector('[data-paso="3"]'),s=document.querySelector("#paso-1"),c=document.querySelector("#paso-2"),o=document.querySelector("#paso-3");e.addEventListener("click",(function(){e.classList.add("actual"),t.classList.remove("actual"),a.classList.remove("actual"),s.classList.remove("ocultar"),s.classList.add("mostrar"),c.classList.add("ocultar"),c.classList.remove("mostrar"),o.classList.add("ocultar"),o.classList.remove("mostrar"),anterior.classList.add("ocultabtn"),siguiente.classList.remove("ocultabtn")})),t.addEventListener("click",(function(){e.classList.remove("actual"),t.classList.add("actual"),a.classList.remove("actual"),s.classList.remove("mostrar"),s.classList.add("ocultar"),c.classList.add("mostrar"),c.classList.remove("ocultar"),o.classList.add("ocultar"),anterior.classList.remove("ocultabtn"),siguiente.classList.remove("ocultabtn")})),a.addEventListener("click",(function(){e.classList.remove("actual"),t.classList.remove("actual"),a.classList.add("actual"),s.classList.remove("mostrar"),s.classList.add("ocultar"),c.classList.remove("mostrar"),c.classList.add("ocultar"),o.classList.remove("ocultar"),o.classList.add("mostrar"),anterior.classList.remove("ocultabtn"),siguiente.classList.add("ocultabtn"),mostrarResumen()}))}function AntSig(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior"),a=document.querySelector('[data-paso="1"]'),s=document.querySelector('[data-paso="2"]'),c=document.querySelector('[data-paso="3"]'),o=document.querySelector("#paso-1"),r=document.querySelector("#paso-2"),i=document.querySelector("#paso-3");e.addEventListener("click",(function(){!0===a.classList.contains("actual")?(a.classList.remove("actual"),s.classList.add("actual"),c.classList.remove("actual"),o.classList.remove("mostrar"),o.classList.add("ocultar"),r.classList.add("mostrar"),r.classList.remove("ocultar"),i.classList.add("ocultar"),t.classList.remove("ocultabtn"),e.classList.remove("ocultabtn")):!0===s.classList.contains("actual")&&(a.classList.remove("actual"),s.classList.remove("actual"),c.classList.add("actual"),o.classList.remove("mostrar"),o.classList.add("ocultar"),r.classList.remove("mostrar"),r.classList.add("ocultar"),i.classList.remove("ocultar"),i.classList.add("mostrar"),e.classList.add("ocultabtn"),mostrarResumen())})),t.addEventListener("click",(function(){!0===c.classList.contains("actual")?(a.classList.remove("actual"),s.classList.add("actual"),c.classList.remove("actual"),o.classList.remove("mostrar"),o.classList.add("ocultar"),r.classList.add("mostrar"),r.classList.remove("ocultar"),i.classList.add("ocultar"),e.classList.remove("ocultabtn")):!0===s.classList.contains("actual")&&(a.classList.add("actual"),s.classList.remove("actual"),c.classList.remove("actual"),o.classList.remove("ocultar"),o.classList.add("mostrar"),r.classList.add("ocultar"),r.classList.remove("mostrar"),i.classList.add("ocultar"),i.classList.remove("mostrar"),t.classList.add("ocultabtn"))}))}async function consultarAPI(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:a,precio:s}=e,c=document.createElement("p");c.classList.add("nombre-servicio"),c.textContent=a;const o=document.createElement("p");o.classList.add("precio-servicio"),o.textContent="$"+s;const r=document.createElement("div");r.classList.add("servicios"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(c),r.appendChild(o),document.querySelector("#servicios").appendChild(r)})}function seleccionarServicio(e){const{id:t}=e,{servicios:a}=cita,s=document.querySelector(`[data-id-servicio="${t}"]`);a.some(e=>e.id===t)?(cita.servicios=a.filter(e=>e.id!==t),s.classList.remove("seleccionado")):(cita.servicios=[...a,e],s.classList.add("seleccionado"))}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function idCliente(){const e=document.querySelector("#id").value;cita.id=e}function seleccionaFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();0===t||6===t?(e.target.value="",mostrarAlerta("error","Lo sentimos, los fines de semana no abrimos",".formulario",!0)):cita.fecha=e.target.value}))}function mostrarAlerta(e,t,a,s=!0){const c=document.querySelector(".alerta");c&&c.remove();const o=document.createElement("div"),r=document.createElement("p");r.classList.add("mensaje_alerta"),r.textContent=t,o.appendChild(r),o.classList.add("alerta"),o.classList.add(e);const i=document.querySelector(a);s&&setTimeout(()=>{o.remove()},3e3),i.appendChild(o)}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<10||t>19?(mostrarAlerta("error","Hora no valida",".formulario"),e.target.value=""):cita.hora=e.target.value}))}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("error","Faltan datos de Servicios, fecha u hora",".contenido-resumen",!1);const{nombre:t,fecha:a,hora:s,servicios:c}=cita,o=document.createElement("h3");o.textContent="Resumen de tus Servicios",e.appendChild(o),c.forEach(t=>{const a=document.createElement("div");a.classList.add("contenedor-servicio");const s=document.createElement("p");s.textContent=t.nombre;const c=document.createElement("p");c.innerHTML="<span>Precio:</span> $"+t.precio,a.appendChild(s),a.appendChild(c),e.appendChild(a)});const r=document.createElement("h3");r.textContent="Resumen de tu Cita",e.appendChild(r);const i=new Date(a),n=i.getMonth(),l=i.getDate()+2,d=i.getFullYear(),u=new Date(Date.UTC(d,n,l)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),m=document.createElement("p");m.innerHTML="<span>Nombre:</span> "+t;const L=document.createElement("p");L.innerHTML="<span>Fecha:</span> "+u;const v=document.createElement("p");v.innerHTML="<span>Hora: </span> "+s;const p=document.createElement("button");p.classList.add("boton-azul"),p.textContent="Reservar",p.onclick=reservarCita,e.appendChild(m),e.appendChild(L),e.appendChild(v),e.appendChild(p)}async function reservarCita(){const{nombre:e,fecha:t,hora:a,servicios:s,id:c}=cita,o=s.map(e=>e.id),r=new FormData;r.append("fecha",t),r.append("hora",a),r.append("usuarioid",c),r.append("servicios",o);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:r});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita creada",text:"Tu cita fue creada con exito!",button:"OK"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Oops...",text:"Ocurrio un error",button:"OK"})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));