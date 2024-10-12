// libraries
import { Link } from 'react-router-dom';
// styles
import styles from './Header.module.css';

// Images
import headerImg from '../../assets/images/Header.png';

const Header = ({ productsRef }) => {
	return (
		<div className={styles.container}>
			<div className={styles.image}>
				<img
					src={headerImg}
					alt='تصویر فروشگاه آنلاین ما'
				/>
				<strong>فروشگاه ما همیشه بازه !</strong>
			</div>
			<div className={styles.text}>
				<h4>فروشگاه آنلاین</h4>
				<p>
					به فروشگاه آنلاین ما خوش آمدید. هر زمان
					و در هر جایی تنها با دسترسی به اینترنت
					می‌توانید محصولات فروشگاه را بازدید کرده
					و در صورت پسندیدن آن، سفارش و خرید خود
					را تکمیل کنید.
				</p>
				<span>اعتبار ما، اعتماد شما</span>
				<div className={styles.links}>
					<button
						onClick={() =>
							productsRef.current.scrollIntoView(
								{
									behavior: 'smooth',
									block: 'start',
								}
							)
						}>
						محصولات
					</button>
					<Link to='/user/signup'>ثبت نام</Link>
				</div>
			</div>
		</div>
	);
};

export default Header;
