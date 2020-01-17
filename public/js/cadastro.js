function validaFormulario(){
    var nome = document.forms["cadastro"]["nome"].value;
    var sobrenome = document.forms["cadastro"]["sobrenome"].value;
    var nascimento = document.forms["cadastro"]["nascimento"].value;
    var genero = document.forms["cadastro"]["genero"].value;
    var comeco = document.forms["cadastro"]["comeco"].value;
    var senha = document.forms["cadastro"]["senha"].value;
    var confirmacao = document.forms["cadastro"]["confirmacao"].value;
    var login = document.forms["cadastro"]["login"].value;
    var email = document.forms["cadastro"]["email"].value;

    var dados = [nome, sobrenome, nascimento, genero, comeco, senha, confirmacao,  login, email];


    // verifica se está vazio
    var i = 0;
    while(i < 8){
        if(dados[i] == ""){
            alert("Preencha todos os campos");
            return false;
        }
        i++;
    }

    // verifica senha
    if(senha != confirmacao){
        alert("Senhas não coincidem");
        return false;
    }
}