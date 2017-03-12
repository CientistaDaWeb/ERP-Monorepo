$.fn.submodulo = function(options) {
    var opt = $.extend(true,{
        debug:  false
    }, options);

    //Envia o formulário por ajax
    $(opt.form).die('submit').unbind('submit').live('submit', function(){
        $(this).ajaxSubmit({
            success: function(){
                //$(opt.modal).html(carregando);
            },
            type: 'post',
            url: "/"+opt.module+"/submodulo/"+opt.controller+"/formulario/",
            target: opt.modal
        });
        return false;
    });

    //Cria o modal
    $(opt.modal).die('dialog').unbind('dialog').dialog({
        modal: true,
        autoOpen: false,
        show: "slide",
        hide: "slide",
        width: '600',
        open: function(){
            if(opt.debug){
                $.jGrowl('<p>'+opt.modal+' '+opt.tab+' '+$(options.tab).tabs('option', 'selected')+'</p>',{
                    theme: "error",
                    sticky: true
                });
            }
        },
        close: function(){
            if(opt.tab){
                $(opt.tab).tabs("load",$(options.tab).tabs('option', 'selected'));
                $(opt.modal).html('');
            }
        }
    });

    //Adiciona ação ao botãode adicionar
    $(".btAdicionar."+opt.controller).die('click').unbind('click').click(function(){
        $(opt.modal).html(carregando);
        var attr = $(this).attr('parent_id');
        if(typeof attr !== 'undefined' && attr !== false && attr != ''){
            url =  "/"+opt.module+"/submodulo/"+opt.controller+"/formulario//"+$(this).attr('parent_id');
        }else{
            url = "/"+opt.module+"/submodulo/"+opt.controller+"/formulario//"+opt.parent_id;
        }
        $.ajax({
            url: url,
            success: function(data){
                $(opt.modal).html(data).dialog('open');
            }
        });
        return false;
    });

    //adiciona ação ao botão de editar
    $(".btEditar."+opt.controller).die('click').unbind('click').click(function(){
        $(opt.modal).html(carregando);
        var id = $(this).attr('source');
        $.ajax({
            url: "/"+opt.module+"/submodulo/"+opt.controller+"/formulario/"+id,
            success: function(data){
                $(opt.modal).html(data).dialog('open');
            }
        });
        return false;
    });

    //adiciona ação ao botão de pagar
    $(".btPagar."+opt.controller).die('click').unbind('click').click(function(){
        $(opt.modal).html(carregando);
        var id = $(this).attr('source');
        $.ajax({
            url: "/"+opt.module+"/submodulo/"+opt.controller+"/pagar/"+id,
            success: function(data){
                $(opt.modal).html(data).dialog('open');
            }
        });
        return false;
    });

    //adiciona ação ao botão de excluir
    $(".btExcluir."+opt.controller).die('click').unbind('click').click(function(){
        $(opt.modal).html(carregando);
        var id = $(this).attr('source');
        if(confirm('Deseja mesmo excluir esse item?')){
            $.ajax({
                url: "/"+opt.module+"/submodulo/"+opt.controller+"/excluir/"+id,
                success: function(data){
                    $(opt.modal).html(data);
                    if(opt.tab){
                        $(opt.tab).tabs('load',$(options.tab).tabs('option', 'selected'));
                    }
                }
            });
        }else{
            return false;
        }
    });

    if(opt.debug){
        $.jGrowl('<p>'+opt.modal+' '+opt.tab+' '+$(options.tab).tabs('option', 'selected')+'</p>',{
            theme: "error",
            sticky: true
        });
    };
};