package pruebaRetrofitJava;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import okhttp3.Headers;


public class LibroCallback implements Callback<Libro>{

	@Override
	public void onFailure(Call<Libro> arg0, Throwable arg1) {
		// TODO Auto-generated method stub

		System.out.println("No se ha podido obtener el libro, asegurese que el id es correcto");
		
	}

	@Override
	public void onResponse(Call<Libro> arg0, Response<Libro> resp) {
		// TODO Auto-generated method stub
		
	Libro libro;
	String contentType;
	int code;
	String message;
	boolean isSuccesful;
	
	libro = resp.body();
	
	Headers cabeceras = resp.headers();
	contentType = cabeceras.get("Content-Type");
	code = resp.code();
	message = resp.message();
	isSuccesful = resp.isSuccessful();
	
	System.out.println("Codigo: " + libro.getCodigo()+ " || Titulo: " +libro.getTitulo()+" || Paginas: "+libro.getNumpag());

	}
	

}
