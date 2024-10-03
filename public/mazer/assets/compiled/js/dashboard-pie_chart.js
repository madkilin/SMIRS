var optionsInventarisKategori = {
    series: [44, 55, 13, 43, 22],
    labels: ['Kategori A', 'Kategori B', 'Kategori C', 'Kategori D', 'Kategori E'],
    chart: {
      type: 'pie',
      width: '100%',
      height: 300,
      // tambahkan properti donut untuk membuat pie chart versi donut
      donut: {
        size: '60%', // ukuran lubang di tengah-tengah pie chart
        background: 'transparent', // warna background lubang
        label: {
          show: true, // menampilkan label di tengah-tengah pie chart
          name: 'Jumlah Inventaris', // nama label
          value: '44%', // nilai label
          color: '#333', // warna label
          fontSize: '16px' // ukuran font label
        }
      }
    },
    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'],
    legend: {
      position: 'bottom'
    }
  };
  
  var chartInventarisKategori = new ApexCharts(document.querySelector("#chart-inventaris-kategori"), optionsInventarisKategori);
  chartInventarisKategori.render();
  
  var optionsUserDivisi = {
    series: [10, 20, 15, 30, 25, 18, 22, 12, 28, 35],
    labels: ['Divisi A', 'Divisi B', 'Divisi C', 'Divisi D', 'Divisi E', 'Divisi F', 'Divisi G', 'Divisi H', 'Divisi I', 'Divisi J'],
    chart: {
      type: 'pie',
      width: '100%',
      height: 300,
      donut: {
        size: '60%',
        background: 'transparent',
        label: {
          show: true,
          name: 'Jumlah User',
          value: '20%',
          color: '#333',
          fontSize: '16px'
        }
      }
    },
    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#2ECC71', '#9B59B6', '#1ABC9C', '#16A085', '#27AE60'],
    legend: {
      position: 'bottom'
    }
  };
  
  var chartUserDivisi = new ApexCharts(document.querySelector("#chart-user-divisi"), optionsUserDivisi);
  chartUserDivisi.render();