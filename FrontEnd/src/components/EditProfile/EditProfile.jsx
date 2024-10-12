// styles
import styles from './EditProfile.module.css';

// API
import { editProfile, getProfile } from '../../services/api';

// Libraries
import { useEffect, useState } from 'react';

const EditProfile = () => {
	const [profile, setProfile] = useState({
		id: null,
		email: '',
		first_name: '',
		last_name: '',
		phone: '',
		password: '',
		confirmPassword: '',
	});
	const [success, setSuccess] = useState(false);
	const [error, setError] = useState(false);

	useEffect(() => {
		const fetch = async () => {
			const data = await getProfile();
			setProfile((prevData) => ({ ...prevData, ...data }));
		};
		fetch();
	}, []);

	const changeHandler = (e) => {
		setProfile((prevProfile) => ({ ...prevProfile, [e.target.name]: e.target.value }));
		success && setSuccess(false);
		error && setError(false);
	};

	const submitHandler = async (e) => {
		e.preventDefault();
		const result = await editProfile(
			profile.email,
			profile.first_name,
			profile.last_name,
			profile.phone,
			profile.password,
			profile.confirmPassword
		);
		result.status === 200 ? setSuccess(true) : setError(result.message);
	};

	return (
		<form className={styles.container}>
			<div className={styles.flexItem}>
				<label htmlFor="">ایمیل:</label>
				<input type="email" placeholder="ایمیل " value={profile.email} name="email" onChange={changeHandler} />
			</div>

			<div className={styles.flexItem}>
				<label htmlFor="">نام:</label>
				<input
					type="text"
					placeholder="نام "
					style={{ direction: 'rtl' }}
					value={profile.first_name}
					name="first_name"
					onChange={changeHandler}
				/>
			</div>

			<div className={styles.flexItem}>
				<label htmlFor="">نام خانوادگی: </label>
				<input
					type="text"
					placeholder="نام خانوادگی"
					style={{ direction: 'rtl' }}
					value={profile.last_name}
					name="last_name"
					onChange={changeHandler}
				/>
			</div>

			<div className={styles.flexItem}>
				<label htmlFor="">شماره:</label>
				<input
					type="text"
					placeholder="شماره همراه "
					value={profile.phone}
					name="phone"
					onChange={changeHandler}
				/>
			</div>

			<div className={styles.flexItem}>
				<label htmlFor="">رمز عبور جدید</label>
				<input
					type="password"
					placeholder="رمز عبور جدید"
					value={profile.password}
					name="password"
					onChange={changeHandler}
				/>
			</div>
			<div className={styles.flexItem}>
				<label htmlFor="">تکرار رمز عبور جدید:</label>
				<input
					type="password"
					placeholder="تکرار رمز عبور جدید"
					value={profile.confirmPassword}
					name="confirmPassword"
					onChange={changeHandler}
				/>
			</div>

			<button onClick={submitHandler}>ثبت تغییرات</button>

			{success && <p className={styles.success}>تغییرات با موفقیت ذخیره شد</p>}
			{error && <p className={styles.error}>{error}</p>}
		</form>
	);
};

export default EditProfile;
