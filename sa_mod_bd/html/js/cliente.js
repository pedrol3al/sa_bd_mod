function aplicarMascara(input, mascara) {
  input.addEventListener('input', () => {
    const numeros = input.value.replace(/\D/g, '');
    let resultado = '';
    let index = 0;

    for (let i = 0; i < mascara.length && index < numeros.length; i++) {
      if (mascara[i] === '#') {
        resultado += numeros[index++];
      } else {
        resultado += mascara[i];
      }
    }

    input.value = resultado;
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const cpf = document.getElementById('cpf');
  const rg = document.getElementById('rg');
  const cep = document.getElementById('cep');
  const telefone = document.getElementById('telefone');
  const celular = document.getElementById('celular');

  if (cpf) aplicarMascara(cpf, '###.###.###-##');
  if (rg) aplicarMascara(rg, '##.###.###-#');
  if (cep) aplicarMascara(cep, '#####-###');
  if (telefone) aplicarMascara(telefone, '(##) ####-####');
  if (celular) aplicarMascara(celular, '(##) #####-####');
});
