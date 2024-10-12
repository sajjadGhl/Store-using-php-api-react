// styles
import styles from './Signup.module.css';

// API
import { signUp, checkToken } from '../../services/api';

// Libraries
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

const Signup = () => {
	const dataEmptyObj = {
		first_name: '',
		last_name: '',
		email: '',
		password: '',
		confirm_password: '',
		phone: '',
	};

	const [data, setData] = useState(dataEmptyObj);
	const [error, setError] = useState('');
	const [success, setSuccess] = useState('');

	const navigate = useNavigate();

	useEffect(() => {
		const tokenHandler = async () => {
			await checkToken() && navigate('/');
		}
		tokenHandler();
	});

	const signupHandler = async (e) => {
		e.preventDefault();
		if (data.password !== data.confirm_password)
			setError('رمز عبور و تکرار رمز عبور برابر نیستند');
		else {
			const res = await signUp(
				data.first_name,
				data.last_name,
				data.email,
				data.password,
				data.phone
			);
			if (res.data.status === 201) {
				// success
				setSuccess('شما با موفقیت ثبت نام شدید');
				setError('');
				setData(dataEmptyObj);
				setTimeout(() => {
					navigate('/user/login');
				}, 2000);
			} else {
				// error
				setError('خطایی هنگام ثبت نام وجود داشت: ' + res.data.message);
				setSuccess('');
			}
		}
	};

	const changeHandler = (e) => {
		if (e.target.id === 'phone' && isNaN(e.target.value)) return;
		else
			setData((data) => ({
				...data,
				[e.target.id]: e.target.value,
			}));
	};

	return (
		<form className={styles.container}>
			<h2>ثبت نام کاربران</h2>
			<div className={styles.form_input}>
				<label htmlFor='email'>ایمیل</label>
				<input
					type='email'
					id='email'
					placeholder='ایمیل'
					value={data.email}
					onChange={changeHandler}
				/>
			</div>

			<div className={`${styles.form_input} ${styles.rtl}`}>
				<label htmlFor='first_name'>نام</label>
				<input
					type='text'
					id='first_name'
					placeholder='نام'
					value={data.first_name}
					onChange={changeHandler}
				/>
			</div>

			<div className={`${styles.form_input} ${styles.rtl}`}>
				<label htmlFor='last_name'>نام خانوادگی</label>
				<input
					type='text'
					id='last_name'
					placeholder='نام خانوادگی'
					value={data.last_name}
					onChange={changeHandler}
				/>
			</div>

			<div className={styles.form_input}>
				<label htmlFor='phone'>شماره همراه</label>
				<input
					type='text'
					id='phone'
					placeholder='شماره همراه'
					value={data.phone}
					onChange={changeHandler}
				/>
			</div>

			<div className={styles.form_input}>
				<label htmlFor='password'>رمز عبور</label>
				<input
					type='password'
					id='password'
					placeholder='رمز عبور'
					value={data.password}
					onChange={changeHandler}
				/>
			</div>

			<div className={styles.form_input}>
				<label htmlFor='confirm_password'>
					تکرار رمز عبور
				</label>
				<input
					type='password'
					id='confirm_password'
					placeholder='تکرار رمز عبور'
					value={data.confirm_password}
					onChange={changeHandler}
				/>
			</div>
			{error && <p className='error'>{error}</p>}
			{success && <p className='success'>{success}</p>}

			<button onClick={signupHandler}>ثبت نام</button>
		</form>
	);
};

export default Signup;
