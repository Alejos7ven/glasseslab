let items = [{id:'#search-art',table:'articulo',rows:8}, {id:"#search-us",table:'user',rows:6}];
async function find(table, param) {
    return new Promise((resolve, reject) => {
        $.ajax({ 
            method:"POST",
            url: "../controller/find.php",
            data: {table:table, param:param},
            dataType: "json",
            success: (response) => { 
                resolve(response);
            } 
        });
    }).then(r => { return r; });
    
} 
items.forEach((element) => {
    $(element.id).keyup(async function (e) {  
        let v = $(this).val();
        if (v != '') { 
            $('.'+element.table+'-main').hide();
            $('.'+element.table+'-search').show();
            $('#'+element.table+'-body').html(`<tr><td colspan=${element.rows}><center>Cargando...</center></td></tr>`);
            let r = await find(element.table, v);
            console.log(r);
            if (r.datos.length > 0) {
                $('#'+element.table+'-body').html(r.datos[0].text);
            }else {
                $('#'+element.table+'-body').html(`<tr><td colspan=${element.rows}><center>No hay resultados.</center></td></tr>`);
            }
            
        }else {
            $('.'+element.table+'-search').hide();
            $('.'+element.table+'-main').show();
            $('#'+element.table+'-body').html(`<tr><td colspan=${element.rows}><center>Cargando...</center></td></tr>`);
        }
        
    });
});
