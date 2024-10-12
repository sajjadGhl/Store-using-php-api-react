// styles
import styles from './Cart.module.css';

// components
import CartItem from '../../components/CartItem/CartItem';

// API
import { useEffect, useState } from 'react';
import { getCart, emptyCart, updateQuantity, deleteCartItem } from '../../services/api';

const Cart = () => {
	// Total Price              ✅
	// Empty Cart               ✅
	// Purchase                 ✅
    // Update quantity          ✅

    const initialData = {cart: [], count: 0, total: 0};
    const [data, setData] = useState(initialData);
    const [pay, setPay] = useState('');

    useEffect(() => {
        const fetch = async () => {
            const cartFetch = await getCart();
            setData(initialData);
            let count = 0, total = 0;
            cartFetch.forEach((item) => {
                count += item.quantity;
                total += item.quantity * item.price;
            });
            setData({cart: cartFetch, count, total});
        };
        fetch();
    }, [data]);

    const quantityHandler = async (id, newQuantity) => {
        const res = await updateQuantity(id, newQuantity);
        if (res.status !== 200) return;
        const newCart = data.cart.map((item) => {
            if (item.id === id) return {...item, quantity: newQuantity};
            return item;
        });
        setData((prevData) => ({...prevData, cart: newCart}));
        setPay('');
	};

    const deleteHandler = async (id) => {
        const res = await deleteCartItem(id);
        if (res.status !== 200) return;
        const newCart = data.cart.filter((item) => item.id !== id);
        setData((prevData) => ({...prevData, cart: newCart}));
        setPay('');
    }

    const emptyCartHandler = async () => {
        const result = await emptyCart();
        if (result.status === 200) setData((prevData) => ({...prevData, cart: []}));
        setPay('');
    }

    const payHandler = async () => {
        emptyCartHandler();
        setPay('پرداخت شما با موفقیت انجام شد.');
    }

	return (
		<div className={styles.container}>
            <div className={styles.totalInfo}>
                <div className={styles.item}>
                        <p>تعداد محصولات: </p>
                        <span>{data.count}</span>
                </div>
                <div className={styles.item}>
                    <p>قیمت کل: </p>
                    <span>{data.total.toLocaleString()} ریال</span>
                </div>
                <div className={styles.buttons}>
                    <button onClick={emptyCartHandler}>حذف همه محصولات</button>
                    <button onClick={payHandler}>تکمیل خرید</button>
                </div>
            </div>
			<div className={styles.cartItems}>
            { pay && <div className={`${styles.success} success`}>{pay}</div> }
                {
                    data.cart.map((item) =>
                    <CartItem key={item.id} data={item}
                        quantityHandler={quantityHandler} deleteHandler={deleteHandler}
                    />)
                }
			</div>
		</div>
	);
};

export default Cart;
