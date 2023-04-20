const toggleSidebarButton = document.querySelector("#toggle-sidebar");
const sidebar = document.querySelector(".sidebar");

toggleSidebarButton.addEventListener("click", () => {
    sidebar.classList.toggle("sidebar-collapsed");
    sidebar.classList.toggle("sidebar-expanded");
});

sidebar.addEventListener("mouseleave", () => {
    sidebar.classList.add("sidebar-collapsed");
    sidebar.classList.remove("sidebar-expanded");
});

sidebar.addEventListener("mouseover", () => {
    sidebar.classList.remove("sidebar-collapsed");
    sidebar.classList.add("sidebar-expanded");
});

// Selecione todos os links com a classe "has-submenu"
const submenuLinks = document.querySelectorAll('.has-submenu');

// Adicione um manipulador de eventos de clique a cada link com a classe "has-submenu"
submenuLinks.forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault(); // previna a ação padrão do link

    const submenu = document.querySelector(link.hash); // selecione o submenu correspondente
    const submenuToggle = link.querySelector('.submenu-toggle'); // selecione o ícone de seta para cima/baixo correspondente

    submenu.classList.toggle('active'); // alterne a classe "active" no submenu correspondente
    if (submenuToggle) {
      submenuToggle.classList.toggle('active');
    }
      });
});
const dropdownMenu = document.querySelector('.dropdown-menu');

//esconde o menu lateral  por padrão
document.querySelector('.sidebar').classList.add('sidebar-collapsed');


