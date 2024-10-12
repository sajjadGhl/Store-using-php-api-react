// components
import { Link } from 'react-router-dom';
import Header from '../../components/Header/Header';
import Products from '../../components/Products/Products';
import Properties from '../Properties/Properties';

// styles
import styles from './Home.module.css';

// libraries
import { useRef } from 'react';

const Home = () => {
	const productsRef = useRef(null);
	return (
		<div className={styles.container}>
			<Header productsRef={productsRef} />
			<div className={styles.products} ref={productsRef}>
				<h3 className={styles.title}>محصولات</h3>
				<Products count={6} />
				<Link to='/products/' className={styles.productsBtn}>مشاهده همه محصولات</Link>
			</div>
			<div>
				<h3 className={styles.title}>چرا ما؟</h3>
				<Properties />
			</div>
		</div>
	);
};

export default Home;
