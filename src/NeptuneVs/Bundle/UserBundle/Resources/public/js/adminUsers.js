$(document).ready(function() 
    {        
        $('*').tooltip();
        
        $('.EditUser').click(function(){
            $('#modalEditUser .modal-body').html('<div style="text-align:center;">Chargement en cours...</div><div style="width: 10px;margin:0 auto;"><div class="loading"></div></div>');
            $('#modalEditUser').modal('show');
            $.ajax({
                url: $(this).attr("href"),               
                success: function(data){                    
                    $("#modalEditUser .modal-body").html(data);                                       
                }
            });
            return false;
        });
        
        $('#sendEdit').click(function(){
            var url = $("#modalEditUser .modal-body form").attr("action");
            var form = $("#modalEditUser .modal-body form").serialize();

            $('#modalEditUser .modal-body').html('<div style="text-align:center;">Enregistrement en cours...</div><div style="width: 10px;margin:0 auto;"><div class="loading"></div></div>');
            $.ajax({
                url: url,
                data: form,
                dataType: 'json',
                success: function(data){
                    if(data.rep == 'ok'){
                        window.location.reload();
                    }else{
                        $("#modalEditUser .modal-body").html(data.data); 
                    }                    
                }
            });
            return false;
        });
        
        $('.delUser').click(function(){
            $('#modalDelUser #validDelUser').attr("href", $(this).attr("link"));
            $('#modalDelUser').modal('show');  
            return false;
        });
        
    });