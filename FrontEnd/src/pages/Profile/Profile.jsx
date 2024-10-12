// styles
import styles from './Profile.module.css';

// Libraries
import { useRef } from 'react';
import { useNavigate } from 'react-router-dom';

// API
import { logout } from '../../services/api';

// Components
import EditProfile from '../../components/EditProfile/EditProfile';
import ShowProfile from '../../components/ShowProfile/ShowProfile';

const Profile = () => {
	const showRef = useRef(null);
	const editRef = useRef(null);

	const navigate = useNavigate();

	const sidebarChangeActiveClass = (e) => {
		if (e.target.tagName === 'LI') {
			Array.from(e.target.parentElement.children).forEach((child) => {
				child.classList.remove(styles.active);
			});
			e.target.classList.add(styles.active);

			if (e.target.id === 'show-profile') {
				showRef.current.classList.remove(styles.hide);
				editRef.current.classList.add(styles.hide);
			} else if (e.target.id === 'edit-profile') {
				showRef.current.classList.add(styles.hide);
				editRef.current.classList.remove(styles.hide);
			}
		}
	};

	const logoutHandler = () => {
		logout();
		navigate('/');
		navigate(0);
	};

	return (
		<div className={styles.container}>
			<ul className={styles.sidebar} onClick={sidebarChangeActiveClass}>
				<li className={styles.active} id="show-profile">
					اطلاعات کاربری
				</li>
				<li id="edit-profile">ویرایش</li>
				<li onClick={logoutHandler}>خروج</li>
			</ul>
			<div className={styles.data}>
				<div ref={showRef} className={styles.showProfileContainer}>
					<ShowProfile />
				</div>
				<div ref={editRef} className={`${styles.hide} ${styles.editProfileContainer}`}>
					<EditProfile />
				</div>
			</div>
		</div>
	);
};

export default Profile;
