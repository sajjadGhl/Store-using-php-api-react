// libraries
import { Link } from 'react-router-dom';

// styles
import styles from './ProductCard.module.css';

// No Image Product Image
import image from '../../assets/images/product.png';

const ProductCard = ({ data: { id, title, description, category_title, price, image_url } }) => {
	return (
		<div className={styles.container}>
			<Link to={`/products/${id}`}>
				<div className={styles.image}>
					<img src={image_url || image} alt={`${title} image`} />
				</div>
				<h5>{title}</h5>
				<p>{description}</p>
				<span>دسته بندی: {category_title}</span>
				<span>قیمت: {price.toLocaleString()} ریال</span>
			</Link>
		</div>
	);
};

export default ProductCard;
