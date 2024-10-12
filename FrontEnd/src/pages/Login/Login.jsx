// styles
import styles from './Login.module.css';

// Libraries
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

// API
import { loginViaEmailPass, checkToken } from '../../services/api';
import { setLocalStorage } from '../../services/localStorage';

const Login = () => {
	const [data, setData] = useState({ email: '', password: '' });
	const [error, setError] = useState(undefined);
	const [redirect, setRedirect] = useState(false);

	const navigate = useNavigate();

	const changeHandler = (e) => {
		setData((prevData) => ({ ...prevData, [e.target.id]: e.target.value }));
	};

	const submitHandler = async (e) => {
		e.preventDefault();
		const res = await loginViaEmailPass(data.email, data.password);
		if (res.data.status === 200) {
			setLocalStorage('token', res.data.body.token);
			setError(undefined);
			setRedirect(true);
		} else {
			setError('ورود ناموفق: ' + res.data.message);
		}
	};

	useEffect(() => {
		const tokenHandler = async () => {
			(await checkToken()) && setRedirect(true);
		};
		tokenHandler();
		if (redirect) {
			navigate('/');
			navigate(0);
		}
	}, [redirect]);

	return (
		<form className={styles.container}>
			<h2>ورود کاربران</h2>
			<div className={styles.form_input}>
				<label htmlFor="email">ایمیل</label>
				<input type="email" id="email" placeholder="ایمیل" onChange={changeHandler} value={data.username} />
			</div>

			<div className={styles.form_input}>
				<label htmlFor="password">رمز عبور</label>
				<input
					type="text"
					id="password"
					placeholder="رمز عبور"
					onChange={changeHandler}
					value={data.password}
				/>
			</div>

			{error && <p className="error">{error}</p>}

			<button onClick={submitHandler}>ورود</button>
		</form>
	);
};

export default Login;
