package pruebaRetrofitJava;

import okhttp3.Headers;
import okhttp3.Request;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.io.IOException;

public class LibroDeleteCallback implements Callback<Void> {

    @Override
    public void onResponse(Call<Void> call, Response<Void> response) {
        System.out.println("Se ha Borrado el libro correctamente!");
    }

    @Override
    public void onFailure(Call<Void> call, Throwable throwable) {
        System.out.println("Ha ocurrido un error, intentelo de nuevo");
    }
}
