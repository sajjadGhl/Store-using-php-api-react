// styles
import styles from './CartItem.module.css';

const CartItem = ( { data, quantityHandler, deleteHandler } ) => {
	return (
		<div className={styles.container}>
			<div className={styles.item}>
				<div className={styles.image}>
					<img src={data.image_url} alt={`${data.title} Image`} />
				</div>
			</div>
			<h6>{data.title}</h6>
			<div>{(data.price).toLocaleString()} ریال</div>
			<div className={styles.quantity}>
				<button onClick={() => quantityHandler(data.cid, data.quantity+1)}>+</button>
				<span>{data.quantity}</span>
				<button onClick={() => quantityHandler(data.cid, data.quantity-1)}>-</button>
			</div>
			<div>{(data.quantity * data.price).toLocaleString()} ریال</div>
			<div>
				<button onClick={() => deleteHandler(data.id)}>حذف محصول</button>
			</div>
		</div>
	);
};
export default CartItem;
