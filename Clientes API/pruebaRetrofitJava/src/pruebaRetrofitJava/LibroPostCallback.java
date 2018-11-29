package pruebaRetrofitJava;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LibroPostCallback implements Callback<Void> {


    @Override
    public void onResponse(Call<Void> call, Response<Void> response) {
        System.out.println("Libro añadido correctamente!");
    }

    @Override
    public void onFailure(Call<Void> call, Throwable throwable) {
        System.out.println("Error al insertar nuevo libro");
    }
}
