// components
import Sidebar from '../../components/Sidebar/Sidebar';
import Products from '../../components/Products/Products';

// styles
import styles from './ProductsPage.module.css';

// API
import { getCategories } from '../../services/api';

// Libraries
import { useEffect, useState } from 'react';

const ProductsPage = () => {
	const [categories, setCategories] = useState([]);
	const [price, setPrice] = useState({ min: 0, max: 10_000_000 });
	const [reRender, setReRender] = useState(true);
	const [searchName, setSearchName] = useState('');

	useEffect(() => {
		const fetchCategories = async () => {
			const res = await getCategories();
			const result = res.body.map((category) => ({
				...category,
				shown: true,
			}));
			setCategories(result);
		};

		fetchCategories();
	}, []);

	return (
		<div className={styles.container}>
			<Sidebar
				categories={{ categories, setCategories }}
				price={{ value: price, set: setPrice }}
				setReRender={setReRender}
				name={{searchName, setSearchName}}
			/>
			<Products categories={categories} price={price} reRender={{ value: reRender, set: setReRender }} name={searchName} />
		</div>
	);
};

export default ProductsPage;
