let reqtext = "Campo requerido";
$('#change').validate({
    rules:{
        old:"required",
        newpsw:{required:true, minlength:8},
        rnewpsw:{required:true, equalTo:"#newpsw"}
    },
    messages:{
        old:{required:reqtext},
        newpsw:{required:reqtext, minlength:"Tu clave debe tener minimo 8 caracteres"},
        rnewpsw:{required:reqtext, equalTo:"Las claves no coinciden"}
    }
});

$('#login-form').validate({
    rules:{
        ci:{required:true},
        pass:{required:true, minlength:8}
    },
    messages:{
        ci:{required:reqtext},
        pass:{required:reqtext, minlength:"Tu clave debe tener minimo 8 caracteres"}
    }
});

$('#create-user-form').validate({
    rules:{
        ci:{required:true, digits:true},
        name:{required:true, lettersonly:true},
        last_name:{required:true, lettersonly:true},
        pass:{required:true, minlength:8},
        rpass:{required:true, equalTo:"#pass"}
    },
    messages:{
        ci:{required:reqtext},
        name:{required:reqtext, lettersonly:"Solo puedes escribir letras"},
        last_name:{required:reqtext, lettersonly:"Solo puedes escribir letras"},
        pass:{required:reqtext, minlength:"Tu clave debe tener minimo 8 caracteres"},
        rpass:{required:reqtext, equalTo:"Las claves no coinciden"}
    }
});
$('.edit-user-form').each(function(e){
    $(this).validate({
        rules:{
            ci:{required:true, digits:true},
            name:{required:true, lettersonly:true},
            last_name:{required:true, lettersonly:true}
        },
        messages:{
            ci:{required:reqtext},
            name:{required:reqtext, lettersonly:"Solo puedes escribir letras"},
            last_name:{required:reqtext, lettersonly:"Solo puedes escribir letras"}
        }
    });
});
$('#create-item-form').validate({
    rules:{
        nombre:{required:true},
        color:{required:true, lettersonly:true},
        marca:{required:true, lettersonly:true},
        precio:{required:true, digits:true}
    },
    messages:{
        nombre:{required:reqtext},
        color:{required:reqtext, lettersonly:"Solo puedes escribir letras"},
        marca:{required:reqtext, lettersonly:"Solo puedes escribir letras"},
        precio:{required:reqtext, digits:"Solo puedes utilizar numeros"}
    }
});
$('.edit-item-form').each(function(e){
    $(this).validate({
    rules:{
        nombre:{required:true},
        color:{required:true, lettersonly:true},
        marca:{required:true, lettersonly:true},
        precio:{required:true, digits:true}
    },
    messages:{
        nombre:{required:reqtext},
        color:{required:reqtext, lettersonly:"Solo puedes escribir letras"},
        marca:{required:reqtext, lettersonly:"Solo puedes escribir letras"},
        precio:{required:reqtext, digits:"Solo puedes utilizar numeros"}
    }
    });
});