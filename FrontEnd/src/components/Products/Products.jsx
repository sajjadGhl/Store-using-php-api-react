// components
import ProductCard from '../../components/ProductCard/ProductCard';
import Loading from '../../components/Loading/Loading';

// styles
import styles from './Products.module.css';

// API
import { getProducts } from '../../services/api';

// Libraries
import { useEffect, useState } from 'react';

const Home = ({ categories, price, reRender, count, name }) => {
	count = count || 99;
	reRender = reRender || { value: false, set: () => {} };
	const [products, setProducts] = useState([]);

	useEffect(() => {
		const getData = async () => {
			const res = await getProducts();
			const result = res.body.filter(
				(product) =>
					!categories ||
					((!categories.length ||
						categories.some((category) => category.shown && category.title === product.category_title)) &&
						product.price <= price.max &&
						product.price >= price.min &&
						product.title.toLowerCase().includes(name.toLowerCase()))
			);
			setProducts(result.slice(0, count));
		};

		reRender.value && reRender.set(false);
		getData();
	}, [reRender.value]);

	return (
		<div className={styles.container} id="products">
			{products ? products.map((product) => <ProductCard key={product.id} data={product} />) : <Loading />}
		</div>
	);
};

export default Home;
