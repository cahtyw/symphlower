function deleteProduct(id) {
    swal({
        title: "Você tem certeza?",
        text: "Uma vez excluído, você terá a chance de restaurar o item, porém tenha certeza do que está fazendo!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! O produto foi deletado.", {
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_item.php?product_id=" + id + "&act=delete";
                    });
            }
            else {

                swal("Seu produto está seguro!", {
                    icon: "success",
                });
            }
        });
}

function resetProduct(id) {
    swal({
        title: "Você tem certeza?",
        text: "Restaurando o produto ele voltará ser mostrado para o cliente, caso tenha estoque disponível!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! O produto foi restaurado.", {
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_item.php?product_id=" + id + "&act=reset";
                    });
            }
            else {
                swal("O produto ainda continua excluído!", {
                    icon: "warning",
                });
            }
        });
}

function editProduct() {
    swal({
        title: "Produto salvo!",
        icon: "success",
        button: "Continuar",
    })
        .then((value) => {
            window.location.href = "panel_item.php";
        });
}

function tellMe() {
    swal("Feito!", "Você será avisado assim que o produto der entrada no estoque de nossa loja!", "success");
}

function deleteUser(id) {
    swal({
        title: "Você tem certeza?",
        text: "Uma vez desativado, você terá a chance de ativar o cadastro, porém tenha certeza do que está fazendo!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! O cadastro foi desativado. A página será recarregada!", {
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_users.php?user_id=" + id + "&act=delete";
                    });
            }
            else {

                swal("Seu cadastro permanece ativo!", {
                    icon: "success",
                });
            }
        });
}

function resetUser(id) {
    swal({
        title: "Você tem certeza?",
        text: "Reativando o cadastro ele poderá ser acessado novamente!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! O cadastro foi reativado. A página será recarregada!", {
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_users.php?user_id=" + id + "&act=reset";
                    });
            }
            else {
                swal("O cadastro continua desativado!", {
                    icon: "warning",
                });
            }
        });
}


function deleteOrder(id) {
    swal({
        title: "Você tem certeza?",
        text: "Uma vez desativado, você terá a chance de ativar o pedido, porém tenha certeza do que está fazendo!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! O pedido foi desativado. A página será recarregada!", {
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_orders.php?order_id=" + id + "&act=delete";
                    });
            }
            else {

                swal("Seu pedido permanece ativo!", {
                    icon: "success",
                });
            }
        });
}

function resetOrder(id) {
    swal({
        title: "Você tem certeza?",
        text: "Reativando o pedido ele poderá ser acessado novamente!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! O pedido foi reativado. A página será recarregada!", {
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_orders.php?order_id=" + id + "&act=reset";
                    });
            }
            else {
                swal("O pedido continua desativado!", {
                    icon: "warning",
                });
            }
        });
}

function setAdmin(id, name){
    swal({
        title: "Você tem certeza?",
        text:"Você quer tornar '"+name+"' como administrador do site?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if(willDelete){
                swal({
                    title: "Prontinho!",
                    text: "O(a) '"+name+"' é um novo administrador do site! A página será carregada!",
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_admin_list.php?uid="+id+"&ac=set";
                    });
            }
            else{
                swal("O(a) '"+name+"' continua como usuário.", {
                    icon: "warning",
                });
            }
        });
}

function unsetAdmin(id, name){
    swal({
        title: "Você tem certeza?",
        text:"Você quer retirar '"+name+"' de administrador do site?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if(willDelete){
                swal({
                    title: "Prontinho!",
                    text: " O(a) '"+name+"' voltou a ser um usuário do site! A página será carregada!",
                    icon: "success",
                    closeOnConfirm: false,
                })
                    .then((value) => {
                        window.location.href = "panel_admin_list.php?uid="+id+"&ac=unset";
                    });
            }
            else{
                swal("O(a) '"+name+"' continua como administrador.", {
                    icon: "warning",
                });
            }
        });
}