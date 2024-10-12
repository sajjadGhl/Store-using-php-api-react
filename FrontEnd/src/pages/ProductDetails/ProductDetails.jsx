// styles
import styles from './ProductDetails.module.css';

// libraries
import { Link, useParams } from 'react-router-dom';

// Temp image
import img from '../../assets/images/logo.png';

// API
import { addToCart, getProduct, isProductInCart, updateQuantity, deleteCartItem } from '../../services/api';
import { useEffect, useState } from 'react';

const ProductDetails = () => {
	const initialDataObject = {
		id: undefined,
		title: undefined,
		price: undefined,
		description: undefined,
		category_id: undefined,
		image_url: undefined,
		category_title: undefined,
	};
	const [data, setData] = useState(initialDataObject);
	const [cartItem, setCartItem] = useState({});

	const { id } = useParams();

	useEffect(() => {
		const fetch = async () => {
			const result = await getProduct(id);
			if (result.status === 200) setData({ ...result.body });
			const isInCartResult = await isProductInCart(id);
			isInCartResult.body.ok && setCartItem(isInCartResult.body);
		};
		fetch();
	}, []);

	const quantityHandler = async (cnt) => {
		if (cartItem.quantity + cnt === 0) {
			const res = await deleteCartItem(cartItem.id);
			res.status === 200 && setCartItem({ ok: false });
			return;
		}
		const res = await updateQuantity(cartItem.id, +cartItem.quantity + cnt);
		res.status === 200 && setCartItem((prevValue) => ({ ...prevValue, quantity: +prevValue.quantity + cnt }));
	};

	const addHandler = async () => {
		const res = await addToCart(data.id);
		res.status === 201 && setCartItem((await isProductInCart(data.id)).body);
	};

	return data.id ? (
		<div className={styles.container}>
			<div className={styles.content}>
				<h3>{data.title}</h3>
				<p>{data.description}</p>
				<div className={styles.price}>
					<div>قیمت: </div>
					<span>{data.price.toLocaleString()} ریال</span>
				</div>
				<div className={styles.categories}>
					<div>دسته بندی:</div>
					<span>{data.category_title}</span>
				</div>
				<div className={styles.links}>
					<Link to="/products"> محصولات دیگر</Link>
					{cartItem.quantity === 0 || !cartItem.quantity ? (
						<button onClick={addHandler}>افزودن به سبد خرید</button>
					) : (
						<>
							<div className={styles.buttons}>
								<button onClick={() => quantityHandler(+1)}>+</button>
								<p>{cartItem.quantity}</p>
								<button onClick={() => quantityHandler(-1)}>-</button>
							</div>
						</>
					)}
				</div>
			</div>
			<div className={styles.image}>
				<img src={data.image_url || img} alt="Product Image" />
			</div>
		</div>
	) : (
		<div>Not Found</div>
	);
};

export default ProductDetails;
