package pruebaRetrofitJava;
import retrofit2.Call;
import retrofit2.http.*;

import java.util.List;


public interface LibroInterface {

	@GET("libro/{id}")
	Call<Libro> getLibro(@Path("id") int id);

	@DELETE("libro/{id}")
	Call<Void> deleteLibro(@Path("id") int id);

	@GET("libro")
	Call<List<Libro>> getListaLibros();

	@Headers({"Content-type:application/json"})
	@POST("libro")
	Call<Void> postLibro(@Body Libro libro);

	@Headers({"Content-type:application/json"})
	@PUT("libro")
	Call<Void> putLibro(@Body Libro libro);

	/**@GET("/libro")
	Call<List<Libro>> getMinMaxPagLibro(@Query("minpag") int minpag, @Query("maxpag") int maxpag);*/

	@GET("/libro")
	Call<List<Libro>> getMinMaxPagLibro(@Query("maxpag") int maxpag);

}
