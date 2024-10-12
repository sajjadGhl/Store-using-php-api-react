// styles
import styles from './Properties.module.css';

// components
import PropertiesCard from '../../components/PropertiesCard/PropertiesCard';

const Properties = () => {
	return (
		<div className={styles.container}>
			<PropertiesCard
				title='اعتماد !'
				description='اعتبار ما اعتماد شماست. با سفارش محصولات فروشگاه، مطمئن باشید به یکی از مشتریان دائمی ما تبدیل می‌شوید'
			/>
			<PropertiesCard
				title='سفارش آنی'
				description='در هر لحظه با وصل شدن به اینترنت، محصول مورد نظر خودتون را به راحتی هر چه تمام تر سفارش دهید.'
			/>
			<PropertiesCard
				title='ارسال سریع'
				description='تیم ما محصول سفارش داده شده توسط شما را در سریع ترین زمان ممکن ارسال خواهد کرد.'
			/>
			<PropertiesCard
				title='قیمت مناسب'
				description='ما خودمان تولید کننده‌ایم. با حذف واسطه‌ها شما محصولات را با قیمتی بسیار مناسب‌تر تهیه خواهید کرد.'
			/>
		</div>
	);
};

export default Properties;

// سفارش هر لحظه
// ارسال سریع
// قیمت مناسب
