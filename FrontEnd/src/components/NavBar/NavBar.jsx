// components
import { NavLink, useNavigate } from 'react-router-dom';

// styles
import styles from './NavBar.module.css';

// images
import logo from '../../assets/images/logo.png';
import mobileIcon from '../../assets/images/mobileIcon.png';
import xIcon from '../../assets/images/x.png';

// API
import { checkToken, logout } from '../../services/api';

// Libraries
import { useEffect, useRef, useState } from 'react';

const NavBar = () => {
	const [loggedIn, setLoggedIn] = useState(false);

	const navigate = useNavigate();

	const menuLinksRef = useRef(null);
	const mobileMenuRef = useRef(null);

	const mobileMenuHandler = () => {
		if (menuLinksRef.current.style.display === 'none') {
			menuLinksRef.current.style.display = 'flex';
			mobileMenuRef.current.childNodes[0].src = xIcon;
		} else {
			menuLinksRef.current.style.display = 'none';
			mobileMenuRef.current.childNodes[0].src = mobileIcon;
		}
	};

	useEffect(() => {
		const tokenHandler = async () => {
			setLoggedIn(await checkToken());
		};
		tokenHandler();
	});

	const logoutHandler = () => {
		logout();
		navigate('/');
		navigate(0);
	};

	return (
		<div className={styles.container}>
			<div className={styles.links} ref={menuLinksRef}>
				<NavLink to="/">صفحه اصلی</NavLink>

				{loggedIn ? (
					<>
						<NavLink to="/user/profile">پروفایل</NavLink>
						<NavLink to="/user/cart">سبد خرید</NavLink>
					</>
				) : (
					<>
						<NavLink to="/user/login">ورود</NavLink>
						<NavLink to="/user/signup">ثبت نام</NavLink>
					</>
				)}

				<NavLink to="/products">محصولات</NavLink>
				{loggedIn && (
					<button className={styles.logoutBtn} onClick={logoutHandler}>
						خروج
					</button>
				)}
			</div>
			<div className={styles.logo}>
				<img src={logo} alt="فروشگاه آنلاین محصولات" />
				<h1>
					<a href="/">فروشگاه آنلاین</a>
				</h1>
			</div>
			<div className={styles.mobileIcon} onClick={mobileMenuHandler} ref={mobileMenuRef}>
				<img src={mobileIcon} />
			</div>
		</div>
	);
};

export default NavBar;
