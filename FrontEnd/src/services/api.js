import axios from 'axios';

import { getLocalStorage, deleteLocalStorage } from './localStorage';

// settings
axios.defaults.baseURL = 'https://api.sajjadghl.ir';
// axios.defaults.baseURL = 'http://store.api/API/';
axios.defaults.headers.common = {
	'Content-Type': 'application/json',
};

// exported functions

const getProducts = async () => {
	const res = await axios.get('/Products/');
	return res.data;
};

const getCategories = async () => {
	const res = await axios.get('/Categories/');
	return res.data;
};

const signUp = async (first_name, last_name, email, password, phone) => {
	const res = await axios.post('/Users/', { first_name, last_name, email, password, phone });
	return res;
};

const loginViaEmailPass = async (email, password) => {
	const res = await axios.post('/User/', { email, password });
	return res;
};

const loginViaToken = async (token) => {
	const res = await axios.post('/User/', { token });
	return res;
};

const checkToken = async () => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;
	const status = await axios.post('/User/', { token }).then((res) => res.data.status);
	if (status !== 200) deleteLocalStorage('token');
	return status === 200;
};

const logout = async () => {
	deleteLocalStorage('token');
};

const getCart = async () => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;
	const data = await axios
		.get('/Cart/', { params: { token }, headers: { 'user-token': token } })
		.then((res) => res.data);
	if (data.status !== 200) {
		deleteLocalStorage('token');
		return [];
	}
	return data.body;
};

const emptyCart = async () => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;

	const data = await axios
		.get('/Cart/', { params: { token, empty: true }, headers: { 'user-token': token } })
		.then((res) => res.data);
	if (data.status !== 200) deleteLocalStorage('token');
	return data;
};

const updateQuantity = async (id, quantity) => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;

	const res = await axios.patch('/Cart/', { id, quantity }, { headers: { 'user-token': token } });
	return res.data;
};

const deleteCartItem = async (id) => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;

	const res = await axios.delete('/Cart/', { headers: { 'user-token': token }, data: { id } });
	return res.data;
};

const getProduct = async (id) => {
	const result = await axios.get('/Products/', { params: { id } });
	return result.data;
};

const addToCart = async (product_id, quantity = 1) => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;

	const result = await axios.post('/Cart/', { product_id, quantity }, { headers: { 'user-token': token } });
	return result.data;
};

const isProductInCart = async (product_id) => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;

	const result = await axios.get('/Cart/', { params: { product_id, token }, headers: { 'user-token': token } });
	return result.data;
};

const getProfile = async () => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;

	const result = await axios.get('/Users/', { params: { token }, headers: { 'user-token': token } });
	return result.data.body;
};

const editProfile = async (email, first_name, last_name, phone, password, confirmPassword) => {
	const token = getLocalStorage('token') || null;
	if (token === null) return false;
	const data = Object.assign(
		{ token },
		email && { email },
		first_name && { first_name },
		last_name && { last_name },
		phone && { phone },
		password && { password },
		confirmPassword && { confirmPassword }
	);
	const res = await axios.patch('/Users/', data, { headers: { 'user-token': token } });
	return res.data;
};

export {
	getProducts,
	getProduct,
	isProductInCart,
	getCategories,
	signUp,
	loginViaEmailPass,
	loginViaToken,
	checkToken,
	logout,
	addToCart,
	getCart,
	emptyCart,
	updateQuantity,
	deleteCartItem,
	getProfile,
	editProfile,
};
