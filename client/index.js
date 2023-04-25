const express = require('express');
const app = express();

app.use(express.static('public'));

app.get('/', (req, res) => res.sendFile(__dirname + '/public/home.html'));
app.get('/olivia-cosmetics', (req, res) => res.sendFile(__dirname + '/public/home.html'));
app.get('/signup', (req, res) => res.sendFile(__dirname + '/public/signup-login.html'));
app.get('/login', (req, res) => res.sendFile(__dirname + '/public/signup-login.html'));
app.get('/olivia-cosmetics-aboutus', (req, res) => res.sendFile(__dirname + '/public/aboutus.html'));
app.get('/product-add', (req, res) => res.sendFile(__dirname + '/public/admin-addproduct.html'));
app.get('/product-update', (req, res) => res.sendFile(__dirname + '/public/admin-updateproduct.html'));
app.get('/cart', (req, res) => res.sendFile(__dirname + '/public/cart.html'));
app.get('/olivia-cosmetics-category', (req, res) => res.sendFile(__dirname + '/public/category.html'));

app.get('/olivia-cosmetics-new', (req, res) => res.sendFile(__dirname + '/public/new.html'));
app.get('/order', (req, res) => res.sendFile(__dirname + '/public/order.html'));
app.get('/olivia-cosmetics-sale', (req, res) => res.sendFile(__dirname + '/public/sale.html'));
app.get('/user', (req, res) => res.sendFile(__dirname + '/public/user.html'));
app.get('/user-list', (req, res) => res.sendFile(__dirname + '/public/userlist.html'));


app.get('/product-detail', (req, res) => res.sendFile(__dirname + '/public/product-detail.html'));
app.get('/order-detail', (req, res) => res.sendFile(__dirname + '/public/order-detail.html'));
app.get('*', (req, res) => res.sendFile(__dirname + '/public/error.html'));





app.listen(3000, () => console.log('Server running on port 3000'));