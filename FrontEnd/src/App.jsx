// styles
import './assets/styles/App.css';

// components
import { Routes, Route } from 'react-router-dom';
import NavBar from './components/NavBar/NavBar';

// pages
import Home from './pages/Home/Home';
import ProductsPage from './pages/ProductsPage/ProductsPage';
import Login from './pages/Login/Login';
import Signup from './pages/Signup/Signup';
import Footer from './components/Footer/Footer';
import ProductDetails from './pages/ProductDetails/ProductDetails';
import Cart from './pages/Cart/Cart';
import Profile from './pages/Profile/Profile';

function App() {
	return (
		<>
			<NavBar />
			<Routes>
				<Route path="/" element={<Home />} />
				<Route path="/products" element={<ProductsPage />} />
				<Route path="/products/:id" element={<ProductDetails />} />

				<Route path="/user/login" element={<Login />} token="test token" />
				<Route path="/user/signup" element={<Signup />} />
				<Route path="/user/profile" element={<Profile />} />
				<Route path="/user/cart" element={<Cart />} />
			</Routes>

			<Footer />
		</>
	);
}

export default App;
